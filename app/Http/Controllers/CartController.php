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
            
            if ($product) {
                $itemTotal = $product->price * $quantity;
                $totalAmount += $itemTotal;
                
                $cartItems[] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $quantity,
                    'image' => $product->image,
                    'total' => $itemTotal
                ];
            }
        }
        
        return view('cart', compact('cartItems', 'totalAmount'));
    }
    
    /**
     * Add a product to cart.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(Product $product, Request $request)
    {
        $quantity = $request->input('quantity', 1);
        
        // Initialize cart if it doesn't exist
        $cart = Session::get('cart', []);
        
        // Add product to cart or update quantity
        if (isset($cart[$product->id])) {
            $cart[$product->id] += $quantity;
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
        
        $cart = Session::get('cart', []);
        
        if (isset($cart[$product->id])) {
            $cart[$product->id] = $request->quantity;
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
}