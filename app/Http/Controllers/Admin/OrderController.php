<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Models\Address;
use App\Events\OrderApproved;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Define valid statuses
        $validStatuses = ['pending', 'processing', 'completed', 'cancelled'];

        // Get the status filter from the request
        $status = $request->query('status');

        // Build the query
        $query = Order::with(['user', 'address', 'items.product', 'paymentMethod'])->latest();

        // Apply status filter if provided and valid
        if ($status && in_array($status, $validStatuses)) {
            $query->where('status', $status);
        }

        // Paginate the results
        $orders = $query->paginate(10);

        // Preserve query parameters in pagination links
        $orders->appends(['status' => $status]);

        // Add breadcrumbs
        $breadcrumbs = [
            ['title' => 'Orders', 'url' => route('admin.orders.index')]
        ];

        return view('admin.orders.index', compact('orders', 'status', 'validStatuses', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('is_admin', false)->get();
        $addresses = Address::all();
        $products = Product::where('status', 'active')->get();
        
        $breadcrumbs = [
            ['title' => 'Orders', 'url' => route('admin.orders.index')],
            ['title' => 'Create Order', 'url' => '#']
        ];
        
        return view('admin.orders.create', compact('users', 'addresses', 'products', 'breadcrumbs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'address_id' => 'required|exists:addresses,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'products' => 'required|array|min:1',
            'products.*' => 'exists:products,id',
            'quantities' => 'required|array|min:1',
            'quantities.*' => 'integer|min:1',
            'notes' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            // Calculate total amount
            $totalAmount = 0;
            foreach ($validated['products'] as $index => $productId) {
                $product = Product::find($productId);
                $quantity = $validated['quantities'][$index];
                $totalAmount += $product->price * $quantity;
            }

            // Create order
            $order = Order::create([
                'user_id' => $validated['user_id'],
                'address_id' => $validated['address_id'],
                'payment_method_id' => $validated['payment_method_id'],
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'payment_status' => 'pending',
                'notes' => $validated['notes'] ?? null,
            ]);

            // Create order items
            foreach ($validated['products'] as $index => $productId) {
                $product = Product::find($productId);
                $quantity = $validated['quantities'][$index];
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'price' => $product->price,
                ]);
            }

            DB::commit();

            return redirect()->route('admin.orders.show', $order->id)
                ->with('success', 'Order created successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Failed to create order: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::with(['user', 'address', 'items.product', 'paymentMethod'])->findOrFail($id);
        
        $breadcrumbs = [
            ['title' => 'Orders', 'url' => route('admin.orders.index')],
            ['title' => 'Order #' . $order->id, 'url' => '#']
        ];
        
        return view('admin.orders.show', compact('order', 'breadcrumbs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $order = Order::with(['user', 'address', 'items.product', 'paymentMethod'])->findOrFail($id);
        $users = User::where('is_admin', false)->get();
        $addresses = Address::all();
        $products = Product::where('status', 'active')->get();
        
        $breadcrumbs = [
            ['title' => 'Orders', 'url' => route('admin.orders.index')],
            ['title' => 'Order #' . $order->id, 'url' => route('admin.orders.show', $order->id)],
            ['title' => 'Edit', 'url' => '#']
        ];
        
        return view('admin.orders.edit', compact('order', 'users', 'addresses', 'products', 'breadcrumbs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $order = Order::findOrFail($id);
        $oldStatus = $order->status;

        // Validate the request with optional fields
        $validated = $request->validate([
            'user_id' => 'sometimes|exists:users,id',
            'address_id' => 'sometimes|exists:addresses,id',
            'status' => 'sometimes|string|in:pending,processing,completed,cancelled',
            'payment_method_id' => 'sometimes|exists:payment_methods,id',
            'payment_status' => 'sometimes|string|in:pending,paid,failed',
            'notes' => 'nullable|string',
            'admin_notes' => 'nullable|string',
            'products' => 'sometimes|array',
            'products.*' => 'exists:products,id',
            'quantities' => 'sometimes|array',
            'quantities.*' => 'integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            // Update order
            $order->update($validated);

            // Update order items if provided
            if (isset($validated['products'])) {
                // Delete existing items
                $order->items()->delete();

                // Create new items
                foreach ($validated['products'] as $index => $productId) {
                    $product = Product::find($productId);
                    $quantity = $validated['quantities'][$index];
                    
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $productId,
                        'quantity' => $quantity,
                        'price' => $product->price,
                    ]);
                }

                // Recalculate total amount
                $totalAmount = $order->items->sum(function ($item) {
                    return $item->price * $item->quantity;
                });
                $order->update(['total_amount' => $totalAmount]);
            }

            DB::commit();

            // Trigger email notification if order status changed to processing or completed
            if (isset($validated['status']) && $validated['status'] !== $oldStatus) {
                if (in_array($validated['status'], ['processing', 'completed'])) {
                    event(new OrderApproved($order));
                }
            }

            return redirect()->route('admin.orders.show', $order->id)
                ->with('success', 'Order updated successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Failed to update order: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);
        
        try {
            $order->items()->delete();
            $order->delete();
            
            return redirect()->route('admin.orders.index')
                ->with('success', 'Order deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete order: ' . $e->getMessage());
        }
    }
}