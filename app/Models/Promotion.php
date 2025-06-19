<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'discount_percentage',
        'is_active',
        'priority',
        'banner_color',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
        'discount_percentage' => 'integer',
        'priority' => 'integer',
    ];

    /**
     * Scope for active promotions
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                    ->where('start_date', '<=', now())
                    ->where('end_date', '>=', now());
    }

    /**
     * Scope for current promotions (active and not expired)
     */
    public function scopeCurrent($query)
    {
        return $query->active()->orderBy('priority', 'desc');
    }

    /**
     * Check if promotion is currently active
     */
    public function isCurrentlyActive()
    {
        return $this->is_active && 
               $this->start_date <= now() && 
               $this->end_date >= now();
    }

    /**
     * Get time remaining until end
     */
    public function getTimeRemaining()
    {
        if (!$this->isCurrentlyActive()) {
            return null;
        }

        $now = Carbon::now();
        $end = Carbon::parse($this->end_date);
        
        return [
            'days' => $now->diffInDays($end),
            'hours' => $now->diffInHours($end) % 24,
            'minutes' => $now->diffInMinutes($end) % 60,
            'seconds' => $now->diffInSeconds($end) % 60,
        ];
    }

    /**
     * Get formatted time remaining string
     */
    public function getFormattedTimeRemaining()
    {
        $time = $this->getTimeRemaining();
        
        if (!$time) {
            return 'Expired';
        }

        return sprintf(
            '%02d:%02d:%02d:%02d',
            $time['days'],
            $time['hours'],
            $time['minutes'],
            $time['seconds']
        );
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
