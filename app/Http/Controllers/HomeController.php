<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Address;
use App\Models\User;
use App\Models\Feedback;
use App\Models\Promotion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Cache the data for better performance
        $cacheKey = 'home_data';
        $cacheDuration = 300; // 5 minutes

        $data = Cache::remember($cacheKey, $cacheDuration, function () {
            // Get categories with eager loading for products
            $categories = Category::withCount('products')->get();
            
            // Get 2 random categories for the featured section
            $featuredCategories = Category::inRandomOrder()
                ->withCount('products')
                ->take(2)
                ->get();
            
            // Get featured products with category relationship
            $featuredProducts = Product::where('is_featured', true)
                ->where('status', 'active')
                ->with('category')
                ->orderBy('created_at', 'desc')
                ->take(8)
                ->get();

            // Get recent feedbacks (limit to 6 for performance)
            $feedbacks = Feedback::orderBy('created_at', 'desc')
                ->take(6)
                ->get();
            
            // Get current active promotion for announcement banner
            $currentPromotion = Promotion::current()->first();
            
            return compact('categories', 'featuredCategories', 'featuredProducts', 'feedbacks', 'currentPromotion');
        });
        
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
        ];
        return view('home', array_merge($data, compact('breadcrumbs')));
    }
    
    /**
     * Show the user profile page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function profile()
    {
        $user = Auth::user();
        
        // Eager load addresses to avoid N+1 queries
        $user->load(['addresses' => function($query) {
            $query->orderBy('is_default', 'desc')->orderBy('created_at', 'desc');
        }]);
        
        return view('profile.user', compact('user'));
    }
    
    /**
     * Store a new address for the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeAddress(Request $request)
    {
        $request->validate([
            'address_line' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'phone_number' => 'required|string|max:20',
        ]);
        
        $user = Auth::user();
        
        // Check if this is the first address (make it default)
        $isDefault = $user->addresses()->count() === 0;
        
        $address = new Address([
            'address_line' => $request->address_line,
            'city' => $request->city,
            'phone_number' => $request->phone_number,
            'notes' => $request->notes,
            'is_default' => $isDefault || $request->has('is_default'),
        ]);
        
        $user->addresses()->save($address);
        
        // If this address is set as default, remove default from other addresses
        if ($address->is_default) {
            $user->addresses()
                ->where('id', '!=', $address->id)
                ->update(['is_default' => false]);
        }
        
        // Clear cache to reflect changes
        Cache::forget('home_data');
        
        return redirect()->route('profile')->with('success', 'Address added successfully!');
    }
}