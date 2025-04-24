<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Display the checkout page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cart = Session::get('cart', []);
        
        // Redirect to cart if empty
        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty!');
        }
        
        $cartItems = [];
        $totalAmount = 0;
        
        foreach ($cart as $id => $quantity) {
            $product = Product::find($id);
            
            if ($product) {
                $itemTotal = $product->price * $quantity;
                $totalAmount += $itemTotal;
                
                $cartItems[] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $quantity,
                    'total' => $itemTotal
                ];
            }
        }
        
        $user = Auth::user();
        $addresses = $user->addresses;
        $defaultAddress = $addresses->where('is_default', true)->first() ?? $addresses->first();
        
        return view('checkout', compact('cartItems', 'totalAmount', 'addresses', 'defaultAddress'));
    }
    
    /**
     * Process the checkout and create order.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:addresses,id',
            'payment_method' => 'required|in:cash_on_delivery,mobile_money,credit_card',
            'notes' => 'nullable|string',
        ]);
        
        $cart = Session::get('cart', []);
        
        // Check if cart is empty
        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty!');
        }
        
        $user = Auth::user();
        $address = Address::findOrFail($request->address_id);
        
        // Ensure address belongs to user
        if ($address->user_id !== $user->id) {
            return redirect()->route('checkout.index')
                ->with('error', 'Invalid address selected!');
        }
        
        // Calculate total amount and verify stock
        $totalAmount = 0;
        $orderItems = [];
        
        foreach ($cart as $productId => $quantity) {
            $product = Product::find($productId);
            
            if (!$product) {
                continue;
            }
            
            // Check stock availability
            if ($product->stock_quantity < $quantity) {
                return redirect()->route('cart.index')
                    ->with('error', "Sorry, we only have {$product->stock_quantity} units of {$product->name} in stock.");
            }
            
            $itemTotal = $product->price * $quantity;
            $totalAmount += $itemTotal;
            
            $orderItems[] = [
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $product->price
            ];
            
            // Decrease stock
            $product->stock_quantity -= $quantity;
            $product->save();
        }
        
        // Begin transaction
        DB::beginTransaction();
        
        try {
            // Create order
            $order = new Order([
                'user_id' => $user->id,
                'address_id' => $address->id,
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
                'notes' => $request->notes,
            ]);
            
            $order->save();
            
            // Create order items
            foreach ($orderItems as $item) {
                $orderItem = new OrderItem([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
                
                $orderItem->save();
            }
            
            // Clear cart
            Session::forget('cart');
            
            DB::commit();
            
            return redirect()->route('orders.show', $order->id)
                ->with('success', 'Your order has been placed successfully!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->route('checkout.index')
                ->with('error', 'An error occurred while processing your order. Please try again.');
        }
    }
}