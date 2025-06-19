<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get 2 random categories for the featured section
        $featuredCategories = Category::inRandomOrder()->take(2)->get();
        
        // Keep your original ordered list for the main categories display
        $categories = Category::orderBy('name')->get();
        
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Categories', 'url' => route('categories.index')],
        ];
        return view('categories.index', compact('categories', 'featuredCategories', 'breadcrumbs'));
    }

    public function show(Category $category)
    {
        $products = $category->products()->paginate(12);
        $relatedCategories = Category::where('id', '!=', $category->id)
            ->inRandomOrder()
            ->limit(4)
            ->get();
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Categories', 'url' => route('categories.index')],
            ['name' => $category->name, 'url' => route('categories.show', $category->slug)],
        ];
        return view('categories.show', compact('category', 'products', 'relatedCategories', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
