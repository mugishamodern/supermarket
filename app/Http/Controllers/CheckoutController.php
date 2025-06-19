<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Address;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Services\PaymentService;

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
                    'total' => $itemTotal,
                    'image' => $product->image,
                ];
            }
        }
        
        $user = Auth::user();
        $addresses = $user->addresses;
        $defaultAddress = $addresses->where('is_default', true)->first() ?? $addresses->first();
        $paymentMethods = PaymentMethod::where('is_active', true)->get();

        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Cart', 'url' => route('cart.index')],
            ['name' => 'Checkout', 'url' => route('checkout.index')],
        ];
        return view('checkout', compact('cartItems', 'totalAmount', 'addresses', 'defaultAddress', 'paymentMethods', 'breadcrumbs'));
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
            'payment_method_id' => 'required|exists:payment_methods,id',
            'notes' => 'nullable|string',
            'mobile_money_phone' => 'nullable|string',
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
        
        $paymentMethod = PaymentMethod::findOrFail($request->payment_method_id);
        
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
                'payment_method_id' => $paymentMethod->id,
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
            
            // Payment processing
            $paymentService = new PaymentService();
            $paymentResult = ['success' => true, 'message' => 'Order placed successfully!'];
            if (strtolower($paymentMethod->name) === 'mobile money') {
                $phone = $request->input('mobile_money_phone');
                if (!$phone) {
                    throw new \Exception('Mobile Money phone number is required.');
                }
                // Determine provider by prefix (MTN: 077, 078; Airtel: 070, 075)
                $provider = null;
                if (preg_match('/^(077|078)/', $phone)) {
                    $provider = 'MTN';
                } elseif (preg_match('/^(070|075)/', $phone)) {
                    $provider = 'Airtel';
                } else {
                    throw new \Exception('Invalid phone number for MTN or Airtel Uganda.');
                }
                $paymentResult = $paymentService->processPayment($order, [
                    'phone_number' => $phone,
                    'provider' => $provider
                ]);
            } else {
                $paymentResult = $paymentService->processPayment($order);
            }
            
            // Clear cart
            Session::forget('cart');
            
            DB::commit();
            
            if ($paymentResult['success']) {
                return redirect()->route('orders.show', $order->id)
                    ->with('success', $paymentResult['message']);
            } else {
                return redirect()->route('orders.show', $order->id)
                    ->with('error', $paymentResult['message']);
            }
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->route('checkout.index')
                ->with('error', 'An error occurred while processing your order: ' . $e->getMessage());
        }
    }
}