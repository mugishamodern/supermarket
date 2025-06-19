<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch products with their categories, with pagination
        $products = Product::with('category')->paginate(10);
        
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get categories for the dropdown
        $categories = Category::all();
        
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:products',
            'slug' => 'nullable|string|unique:products,slug',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'stock_quantity' => 'required|integer|min:0',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'featured' => 'nullable|boolean',
        ]);
    
        $product = new Product();
        $product->name = $validated['name'];
        $product->slug = $validated['slug'] ?? Str::slug($validated['name']);
        $product->description = $validated['description'];
        $product->price = $validated['price'];
        $product->category_id = $validated['category_id'];
        $product->stock_quantity = $validated['stock_quantity'];
        $product->is_featured = $request->has('featured');
    
        // Handle multiple image uploads
        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('products', 'public');
                $images[] = $path;
            }
        }
        $product->images = $images;
        // For backward compatibility, set the first image as the main image
        $product->image = $images[0] ?? null;
    
        $product->save();
    
        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with('category')->findOrFail($id);
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);
    
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:products,name,' . $id,
            'slug' => 'nullable|string|unique:products,slug,' . $id,
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_featured' => 'nullable|boolean',
        ]);
    
        // Update fields
        $product->name = $validated['name'];
        $product->slug = $validated['slug'] ?? Str::slug($validated['name']);
        $product->description = $validated['description'];
        $product->price = $validated['price'];
        $product->category_id = $validated['category_id'];
        $product->stock_quantity = $validated['stock'];
        $product->is_featured = $request->has('featured');
    
        // Handle multiple image uploads (append to existing)
        $images = $product->images ?? [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('products', 'public');
                $images[] = $path;
            }
        }
        $product->images = $images;
        // For backward compatibility, set the first image as the main image
        $product->image = $images[0] ?? null;
    
        $product->save();
    
        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        
        // Delete associated images
        $images = json_decode($product->images ?? '[]', true);
        foreach ($images as $image) {
            Storage::disk('public')->delete($image);
        }
        
        $product->delete();
        
        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}