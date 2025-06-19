<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'stock_quantity',
        'image',
        'is_featured',
        'category_id',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'is_featured' => 'boolean',
        'images' => 'array',
    ];
    
    /**
     * Get the category that owns the product.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    /**
     * Get the order items for the product.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function activePromotion()
    {
        $now = now();
        return \App\Models\Promotion::where('is_active', true)
            ->where(function($q) {
                $q->whereNull('category_id')->orWhere('category_id', $this->category_id);
            })
            ->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->orderByDesc('priority')
            ->first();
    }

    public function discountedPrice()
    {
        $promotion = $this->activePromotion();
        if ($promotion && $promotion->discount_percentage) {
            return round($this->price * (1 - $promotion->discount_percentage / 100), 2);
        }
        return $this->price;
    }
}