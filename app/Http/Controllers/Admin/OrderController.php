<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Models\Address;
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
    $query = Order::with(['user', 'address', 'items.product'])->latest();

    // Apply status filter if provided and valid
    if ($status && in_array($status, $validStatuses)) {
        $query->where('status', $status);
    }

    // Paginate the results
    $orders = $query->paginate(10);

    // Preserve query parameters in pagination links
    $orders->appends(['status' => $status]);

    return view('admin.orders.index', compact('orders', 'status', 'validStatuses'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get data for dropdowns
        $users = User::all();
        $addresses = Address::all();
        $products = Product::where('status', 'active')->get();
        
        return view('admin.orders.create', compact('users', 'addresses', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'address_id' => 'required|exists:addresses,id',
            'status' => 'required|string|in:pending,processing,completed,cancelled',
            'payment_method' => 'required|string',
            'payment_status' => 'required|string|in:paid,unpaid',
            'notes' => 'nullable|string',
            'products' => 'required|array',
            'products.*' => 'exists:products,id',
            'quantities' => 'required|array',
            'quantities.*' => 'integer|min:1',
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
            
            // Create the order
            $order = new Order();
            $order->user_id = $validated['user_id'];
            $order->address_id = $validated['address_id'];
            $order->total_amount = $totalAmount;
            $order->status = $validated['status'];
            $order->payment_method = $validated['payment_method'];
            $order->payment_status = $validated['payment_status'];
            $order->notes = $validated['notes'] ?? null;
            $order->save();
            
            // Create order items
            foreach ($validated['products'] as $index => $productId) {
                $product = Product::find($productId);
                $quantity = $validated['quantities'][$index];
                
                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $productId;
                $orderItem->quantity = $quantity;
                $orderItem->price = $product->price;
                $orderItem->save();
                
                // Optionally update stock
                // $product->stock -= $quantity;
                // $product->save();
            }
            
            DB::commit();
            
            return redirect()->route('admin.orders.index')
                ->with('success', 'Order created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create order: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::with(['user', 'address', 'items.product'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $order = Order::with(['user', 'address', 'items.product'])->findOrFail($id);
        $users = User::all();
        $addresses = Address::all();
        $products = Product::where('status', 'active')->get();
        
        return view('admin.orders.edit', compact('order', 'users', 'addresses', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    $order = Order::findOrFail($id);

    // Validate the request with optional fields
    $validated = $request->validate([
        'user_id' => 'sometimes|exists:users,id',
        'address_id' => 'sometimes|exists:addresses,id',
        'status' => 'sometimes|string|in:pending,processing,completed,cancelled',
        'payment_method' => 'sometimes|string',
        'payment_status' => 'sometimes|string|in:paid,unpaid',
        'notes' => 'nullable|string',
        'products' => 'sometimes|array',
        'products.*' => 'exists:products,id',
        'quantities' => 'sometimes|array',
        'quantities.*' => 'integer|min:1',
    ]);

    DB::beginTransaction();

    try {
        // Update only provided fields
        if (isset($validated['status'])) {
            $order->status = $validated['status'];
        }
        if (isset($validated['notes'])) {
            $order->admin_notes = $validated['notes'] ?? null; // Use admin_notes or notes based on your schema
        }

        // Handle full order update if products are provided
        if (isset($validated['products']) && isset($validated['quantities'])) {
            $totalAmount = 0;
            foreach ($validated['products'] as $index => $productId) {
                $product = Product::find($productId);
                $quantity = $validated['quantities'][$index];
                $totalAmount += $product->price * $quantity;
            }

            $order->user_id = $validated['user_id'] ?? $order->user_id;
            $order->address_id = $validated['address_id'] ?? $order->address_id;
            $order->total_amount = $totalAmount;
            $order->payment_method = $validated['payment_method'] ?? $order->payment_method;
            $order->payment_status = $validated['payment_status'] ?? $order->payment_status;

            // Delete existing order items
            OrderItem::where('order_id', $order->id)->delete();

            // Create new order items
            foreach ($validated['products'] as $index => $productId) {
                $product = Product::find($productId);
                $quantity = $validated['quantities'][$index];

                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $productId;
                $orderItem->quantity = $quantity;
                $orderItem->price = $product->price;
                $orderItem->save();
            }
        }

        $order->save();

        DB::commit();

        return redirect()->route('admin.orders.show', $order->id)
            ->with('success', 'Order updated successfully.');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Failed to update order: ' . $e->getMessage());
    }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);
        
        // Order items will be deleted automatically if you have cascading deletes set up
        // Otherwise, you can delete them manually:
        OrderItem::where('order_id', $order->id)->delete();
        
        $order->delete();
        
        return redirect()->route('admin.orders.index')
            ->with('success', 'Order deleted successfully.');
    }
}