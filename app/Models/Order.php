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
        'payment_method_id',
        'payment_status',
        'notes',
        'admin_notes',
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
     * Get the payment method for the order.
     */
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
    
    /**
     * Get the items for the order.
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the order items (alias for items).
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the payment method name.
     */
    public function getPaymentMethodNameAttribute()
    {
        if ($this->paymentMethod) {
            return $this->paymentMethod->name;
        }
        
        // Fallback to old payment_method field
        $paymentLabels = [
            'cash_on_delivery' => 'Cash on Delivery',
            'mobile_money' => 'Mobile Money',
            'credit_card' => 'Credit/Debit Card'
        ];
        
        return $paymentLabels[$this->payment_method] ?? $this->payment_method ?? 'Not specified';
    }

    /**
     * Get the status badge class.
     */
    public function getStatusBadgeClassAttribute()
    {
        $statusClasses = [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'processing' => 'bg-blue-100 text-blue-800',
            'completed' => 'bg-green-100 text-green-800',
            'cancelled' => 'bg-red-100 text-red-800',
        ];
        
        return $statusClasses[$this->status] ?? 'bg-gray-100 text-gray-800';
    }

    /**
     * Get the payment status badge class.
     */
    public function getPaymentStatusBadgeClassAttribute()
    {
        $statusClasses = [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'paid' => 'bg-green-100 text-green-800',
            'failed' => 'bg-red-100 text-red-800',
        ];
        
        return $statusClasses[$this->payment_status] ?? 'bg-gray-100 text-gray-800';
    }
}