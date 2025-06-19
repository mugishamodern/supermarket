<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Clear existing data
        $this->truncateTables();
        
        // Call seeders in order
        $this->call([
            AdminUserSeeder::class,
            PaymentMethodSeeder::class,
            TestDataSeeder::class,
            FeedbackSeeder::class,
        ]);
        
        // Clear cache after seeding
        \Illuminate\Support\Facades\Cache::flush();
    }
    
    /**
     * Truncate all tables to start fresh
     */
    private function truncateTables(): void
    {
        $tables = [
            'users',
            'categories',
            'products',
            'orders',
            'order_items',
            'addresses',
            'feedback',
            'contact_inquiries',
            'payment_methods',
            'wishlists'
        ];
        
        foreach ($tables as $table) {
            DB::table($table)->delete();
        }
    }
}

