<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Address;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create categories
        $categories = [
            ['name' => 'Fresh Produce', 'slug' => 'fresh-produce', 'description' => 'Fresh fruits and vegetables'],
            ['name' => 'Dairy & Eggs', 'slug' => 'dairy-eggs', 'description' => 'Milk, cheese, eggs and dairy products'],
            ['name' => 'Meat & Fish', 'slug' => 'meat-fish', 'description' => 'Fresh meat and seafood'],
            ['name' => 'Bakery', 'slug' => 'bakery', 'description' => 'Fresh bread and pastries'],
            ['name' => 'Pantry', 'slug' => 'pantry', 'description' => 'Canned goods and dry foods'],
            ['name' => 'Beverages', 'slug' => 'beverages', 'description' => 'Drinks and beverages'],
            ['name' => 'Household', 'slug' => 'household', 'description' => 'Cleaning and household items'],
            ['name' => 'Personal Care', 'slug' => 'personal-care', 'description' => 'Health and beauty products'],
        ];

        foreach ($categories as $categoryData) {
            Category::create($categoryData);
        }

        // Create sample products (reduced from original for better performance)
        $products = [
            // Fresh Produce
            ['name' => 'Fresh Tomatoes', 'price' => 2500, 'stock_quantity' => 50, 'category_id' => 1, 'is_featured' => true],
            ['name' => 'Green Bananas', 'price' => 3000, 'stock_quantity' => 30, 'category_id' => 1, 'is_featured' => true],
            ['name' => 'Fresh Onions', 'price' => 1500, 'stock_quantity' => 40, 'category_id' => 1],
            ['name' => 'Sweet Potatoes', 'price' => 2000, 'stock_quantity' => 25, 'category_id' => 1],
            
            // Dairy & Eggs
            ['name' => 'Fresh Milk 1L', 'price' => 3500, 'stock_quantity' => 20, 'category_id' => 2, 'is_featured' => true],
            ['name' => 'Eggs (12 pieces)', 'price' => 4000, 'stock_quantity' => 15, 'category_id' => 2, 'is_featured' => true],
            ['name' => 'Cheddar Cheese', 'price' => 8000, 'stock_quantity' => 10, 'category_id' => 2],
            ['name' => 'Yogurt 500ml', 'price' => 2500, 'stock_quantity' => 12, 'category_id' => 2],
            
            // Meat & Fish
            ['name' => 'Beef Steak 1kg', 'price' => 25000, 'stock_quantity' => 8, 'category_id' => 3, 'is_featured' => true],
            ['name' => 'Chicken Breast 1kg', 'price' => 12000, 'stock_quantity' => 15, 'category_id' => 3],
            ['name' => 'Fresh Fish 1kg', 'price' => 15000, 'stock_quantity' => 10, 'category_id' => 3],
            ['name' => 'Pork Chops 1kg', 'price' => 18000, 'stock_quantity' => 6, 'category_id' => 3],
            
            // Bakery
            ['name' => 'Fresh Bread', 'price' => 1500, 'stock_quantity' => 25, 'category_id' => 4, 'is_featured' => true],
            ['name' => 'Croissants (6 pieces)', 'price' => 3000, 'stock_quantity' => 8, 'category_id' => 4],
            ['name' => 'Cake Slice', 'price' => 2000, 'stock_quantity' => 12, 'category_id' => 4],
            
            // Pantry
            ['name' => 'Rice 5kg', 'price' => 15000, 'stock_quantity' => 20, 'category_id' => 5, 'is_featured' => true],
            ['name' => 'Cooking Oil 1L', 'price' => 5000, 'stock_quantity' => 15, 'category_id' => 5],
            ['name' => 'Sugar 2kg', 'price' => 4000, 'stock_quantity' => 18, 'category_id' => 5],
            ['name' => 'Flour 2kg', 'price' => 3500, 'stock_quantity' => 22, 'category_id' => 5],
            
            // Beverages
            ['name' => 'Mineral Water 1L', 'price' => 1000, 'stock_quantity' => 30, 'category_id' => 6, 'is_featured' => true],
            ['name' => 'Orange Juice 1L', 'price' => 3500, 'stock_quantity' => 12, 'category_id' => 6],
            ['name' => 'Coffee Beans 500g', 'price' => 8000, 'stock_quantity' => 8, 'category_id' => 6],
            ['name' => 'Tea Bags (50 pieces)', 'price' => 2500, 'stock_quantity' => 15, 'category_id' => 6],
            
            // Household
            ['name' => 'Laundry Detergent 2L', 'price' => 8000, 'stock_quantity' => 10, 'category_id' => 7],
            ['name' => 'Dish Soap 500ml', 'price' => 2000, 'stock_quantity' => 15, 'category_id' => 7],
            ['name' => 'Toilet Paper (12 rolls)', 'price' => 5000, 'stock_quantity' => 20, 'category_id' => 7],
            
            // Personal Care
            ['name' => 'Toothpaste', 'price' => 3000, 'stock_quantity' => 25, 'category_id' => 8],
            ['name' => 'Shampoo 500ml', 'price' => 4500, 'stock_quantity' => 12, 'category_id' => 8],
            ['name' => 'Soap Bar', 'price' => 1500, 'stock_quantity' => 30, 'category_id' => 8],
        ];

        foreach ($products as $productData) {
            $product = Product::create([
                'name' => $productData['name'],
                'slug' => Str::slug($productData['name']),
                'description' => 'High quality ' . strtolower($productData['name']) . ' from local suppliers.',
                'price' => $productData['price'],
                'stock_quantity' => $productData['stock_quantity'],
                'category_id' => $productData['category_id'],
                'is_featured' => $productData['is_featured'] ?? false,
            ]);
        }

        // Create a test user with address
        $user = User::create([
            'name' => 'Test Customer',
            'email' => 'customer@test.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        Address::create([
            'user_id' => $user->id,
            'address_line' => '123 Test Street',
            'city' => 'Kasese',
            'phone_number' => '+256 776 123456',
            'is_default' => true,
        ]);

        $this->command->info('Test data seeded successfully!');
        $this->command->info('Test user: customer@test.com / password');
    }
}