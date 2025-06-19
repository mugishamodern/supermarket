<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use App\Models\Category;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index()
    {
        $promotions = Promotion::with('category')->orderByDesc('created_at')->paginate(10);
        return view('admin.promotions.index', compact('promotions'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.promotions.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'discount_percentage' => 'required|integer|min:1|max:100',
            'is_active' => 'boolean',
            'priority' => 'nullable|integer',
            'banner_color' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
        ]);
        if (empty($validated['category_id'])) {
            $validated['category_id'] = null;
        }
        Promotion::create($validated);
        return redirect()->route('admin.promotions.index')->with('success', 'Promotion created successfully.');
    }

    public function edit(Promotion $promotion)
    {
        $categories = Category::all();
        return view('admin.promotions.edit', compact('promotion', 'categories'));
    }

    public function update(Request $request, Promotion $promotion)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'discount_percentage' => 'required|integer|min:1|max:100',
            'is_active' => 'boolean',
            'priority' => 'nullable|integer',
            'banner_color' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
        ]);
        if (empty($validated['category_id'])) {
            $validated['category_id'] = null;
        }
        $promotion->update($validated);
        return redirect()->route('admin.promotions.index')->with('success', 'Promotion updated successfully.');
    }

    public function destroy(Promotion $promotion)
    {
        $promotion->delete();
        return redirect()->route('admin.promotions.index')->with('success', 'Promotion deleted successfully.');
    }
} 