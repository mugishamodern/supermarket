<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'address_id',
        'total_amount',
        'status',
        'payment_method',
        'payment_status',
        'notes',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'total_amount' => 'decimal:2',
    ];
    
    /**
     * Get the user that owns the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the address that was used for the order.
     */
    public function address()
    {
        return $this->belongsTo(Address::class);
    }
    
    /**
     * Get the items for the order.
     */
    public function Items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function OrderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}