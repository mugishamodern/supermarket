<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Promotion;
use Carbon\Carbon;

class PromotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing promotions
        Promotion::truncate();

        // Create sample promotions
        $promotions = [
            [
                'title' => 'Weekend Flash Sale',
                'description' => 'Special Weekend Sale! Up to 30% off on all electronics',
                'start_date' => Carbon::now()->subDays(1),
                'end_date' => Carbon::now()->addDays(2),
                'discount_percentage' => 30,
                'is_active' => true,
                'priority' => 3,
                'banner_color' => 'red',
            ],
            [
                'title' => 'New Customer Discount',
                'description' => 'Welcome to Mukora! Get 15% off your first order',
                'start_date' => Carbon::now()->subDays(5),
                'end_date' => Carbon::now()->addDays(30),
                'discount_percentage' => 15,
                'is_active' => true,
                'priority' => 2,
                'banner_color' => 'blue',
            ],
            [
                'title' => 'Free Delivery',
                'description' => 'Free delivery on orders over UGX 50,000',
                'start_date' => Carbon::now()->subDays(10),
                'end_date' => Carbon::now()->addDays(15),
                'discount_percentage' => null,
                'is_active' => true,
                'priority' => 1,
                'banner_color' => 'green',
            ],
            [
                'title' => 'Holiday Special',
                'description' => 'Holiday season is here! 25% off on all groceries',
                'start_date' => Carbon::now()->addDays(5),
                'end_date' => Carbon::now()->addDays(20),
                'discount_percentage' => 25,
                'is_active' => true,
                'priority' => 4,
                'banner_color' => 'purple',
            ],
        ];

        foreach ($promotions as $promotion) {
            Promotion::create($promotion);
        }
    }
}
