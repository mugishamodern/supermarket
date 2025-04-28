<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Address;
use App\Models\User;
use App\Models\Feedback;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
{
    // Get all categories
    $categories = Category::all();
    
    // Get 2 random categories for the featured section
    $featuredCategories = Category::inRandomOrder()->take(2)->get();
    
    // Get featured products
    $featuredProducts = Product::where('is_featured', true)
        ->orderBy('created_at', 'desc')
        ->take(8)
        ->get();

    // Fetch all feedbacks from the database
    $feedbacks = Feedback::all();
    
    return view('home', compact('categories', 'featuredCategories', 'featuredProducts', 'feedbacks'));
}
    
    /**
     * Show the user profile page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function profile()
    {
        $user = Auth::user();
        $addresses = $user->addresses;
        
        return view('profile.user', compact('user', 'addresses'));
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
        
        return redirect()->route('profile')->with('success', 'Address added successfully!');
    }
}