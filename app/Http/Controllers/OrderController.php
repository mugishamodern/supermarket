<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Address;
use App\Models\Cart;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('address')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('checkout.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:addresses,id',
            'payment_method' => 'required|in:cash_on_delivery,mobile_money,credit_card',
            'notes' => 'nullable|string|max:500',
        ]);

        // Check for valid address ownership
        $address = Address::findOrFail($request->address_id);
        if ($address->user_id !== Auth::id()) {
            return back()->with('error', 'Invalid address selected');
        }

        // Get cart items
        $cartItems = Cart::where('user_id', Auth::id())->get();
        if ($cartItems->isEmpty()) {
            return redirect()->route('products.index')->with('error', 'Your cart is empty');
        }

        // Calculate total amount
        $totalAmount = 0;
        foreach ($cartItems as $cartItem) {
            $totalAmount += $cartItem->product->price * $cartItem->quantity;
        }

        // Create order
        $order = Order::create([
            'user_id' => Auth::id(),
            'address_id' => $request->address_id,
            'total_amount' => $totalAmount,
            'payment_method' => $request->payment_method,
            'notes' => $request->notes,
            'status' => 'pending',
            'payment_status' => 'pending'
        ]);

        // Create order items
        foreach ($cartItems as $cartItem) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->product->price,
            ]);
        }

        // Clear cart
        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('orders.show', $order->id)->with('success', 'Order placed successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->with(['address', 'orderItems.product'])
            ->firstOrFail();
            
        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Orders can't be edited by customers after placement
        return redirect()->route('orders.show', $id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Only allow cancellation
        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
            
        if ($order->status === 'pending') {
            $order->update(['status' => 'cancelled']);
            return redirect()->route('orders.show', $id)->with('success', 'Order cancelled successfully');
        }
        
        return redirect()->route('orders.show', $id)->with('error', 'This order cannot be cancelled');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Not allowing deletion of orders for audit purposes
        return redirect()->route('orders.index')->with('error', 'Orders cannot be deleted');
    }
}