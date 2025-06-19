<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Display the cart.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cart = Session::get('cart', []);
        $cartItems = [];
        $totalAmount = 0;
        
        foreach ($cart as $id => $quantity) {
            $product = Product::find($id);
            
            if ($product && $product->status === 'active') {
                $itemTotal = $product->price * $quantity;
                $totalAmount += $itemTotal;
                
                $cartItems[] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $quantity,
                    'image' => $product->image,
                    'total' => $itemTotal,
                    'stock' => $product->stock ?? 100
                ];
            } else {
                // Remove invalid products from cart
                unset($cart[$id]);
            }
        }
        
        // Update session with cleaned cart
        Session::put('cart', $cart);
        
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Cart', 'url' => route('cart.index')],
        ];
        return view('cart', compact('cartItems', 'totalAmount', 'breadcrumbs'));
    }
    
    /**
     * Add a product to cart.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(Product $product, Request $request)
    {
        // Check if product is active
        if ($product->status !== 'active') {
            return response()->json([
                'success' => false,
                'message' => 'This product is not available for purchase.'
            ], 400);
        }

        $quantity = $request->input('quantity', 1);
        
        // Validate quantity
        if ($quantity < 1) {
            return response()->json([
                'success' => false,
                'message' => 'Quantity must be at least 1.'
            ], 400);
        }

        // Check stock availability
        $availableStock = $product->stock ?? 100;
        if ($quantity > $availableStock) {
            return response()->json([
                'success' => false,
                'message' => "Only {$availableStock} items available in stock."
            ], 400);
        }
        
        // Initialize cart if it doesn't exist
        $cart = Session::get('cart', []);
        
        // Add product to cart or update quantity
        if (isset($cart[$product->id])) {
            $newQuantity = $cart[$product->id] + $quantity;
            if ($newQuantity > $availableStock) {
                return response()->json([
                    'success' => false,
                    'message' => "Cannot add more items. Only {$availableStock} items available in stock."
                ], 400);
            }
            $cart[$product->id] = $newQuantity;
        } else {
            $cart[$product->id] = $quantity;
        }
        
        // Save cart back to session
        Session::put('cart', $cart);
        
        return response()->json([
            'success' => true,
            'message' => 'Product added to cart successfully!',
            'cartCount' => count($cart)
        ]);
    }
    
    /**
     * Update product quantity in cart.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);
        
        $quantity = $request->input('quantity');
        $availableStock = $product->stock ?? 100;
        
        // Check stock availability
        if ($quantity > $availableStock) {
            return redirect()->route('cart.index')
                ->with('error', "Only {$availableStock} items available in stock.");
        }
        
        $cart = Session::get('cart', []);
        
        if (isset($cart[$product->id])) {
            if ($quantity == 0) {
                unset($cart[$product->id]);
            } else {
                $cart[$product->id] = $quantity;
            }
            Session::put('cart', $cart);
        }
        
        return redirect()->route('cart.index')
            ->with('success', 'Cart updated successfully!');
    }
    
    /**
     * Remove a product from cart.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Product $product)
    {
        $cart = Session::get('cart', []);
        
        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            Session::put('cart', $cart);
        }
        
        return redirect()->route('cart.index')
            ->with('success', 'Product removed from cart!');
    }

    /**
     * Clear the entire cart.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clear()
    {
        Session::forget('cart');
        
        return redirect()->route('cart.index')
            ->with('success', 'Cart cleared successfully!');
    }

    /**
     * Get cart count for AJAX requests.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCount()
    {
        $cart = Session::get('cart', []);
        
        return response()->json([
            'count' => count($cart)
        ]);
    }
}