<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Display the user's wishlist.
     */
    public function index()
    {
        $wishlistItems = Wishlist::where('user_id', Auth::id())
            ->with('product')
            ->get();

        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Wishlist', 'url' => route('wishlist.index')],
        ];
        return view('wishlist.index', compact('wishlistItems', 'breadcrumbs'));
    }

    /**
     * Add a product to wishlist.
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $productId = $request->input('product_id');
        $userId = Auth::id();

        // Check if already in wishlist
        $existing = Wishlist::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'Product is already in your wishlist'
            ]);
        }

        // Add to wishlist
        Wishlist::create([
            'user_id' => $userId,
            'product_id' => $productId
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product added to wishlist successfully'
        ]);
    }

    /**
     * Remove a product from wishlist.
     */
    public function remove($id)
    {
        $wishlistItem = Wishlist::where('user_id', Auth::id())
            ->where('id', $id)
            ->first();

        if (!$wishlistItem) {
            return back()->with('error', 'Wishlist item not found');
        }

        $wishlistItem->delete();

        return back()->with('success', 'Product removed from wishlist');
    }

    /**
     * Move item from wishlist to cart.
     */
    public function moveToCart($id)
    {
        $wishlistItem = Wishlist::where('user_id', Auth::id())
            ->where('id', $id)
            ->with('product')
            ->first();

        if (!$wishlistItem) {
            return back()->with('error', 'Wishlist item not found');
        }

        // Add to cart
        $cart = session()->get('cart', []);
        $productId = $wishlistItem->product_id;

        if (isset($cart[$productId])) {
            $cart[$productId]++;
        } else {
            $cart[$productId] = 1;
        }

        session()->put('cart', $cart);

        // Remove from wishlist
        $wishlistItem->delete();

        return back()->with('success', 'Product moved to cart successfully');
    }
} 