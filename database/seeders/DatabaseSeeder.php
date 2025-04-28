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
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Call additional seeders
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            AddressSeeder::class,
            ProductSeeder::class,
            OrderSeeder::class,
            OrderItemSeeder::class,
        ]);
    }
}

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        DB::table('users')->insert([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'is_admin' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create regular users
        for ($i = 1; $i <= 10; $i++) {
            DB::table('users')->insert([
                'name' => 'User '.$i,
                'email' => 'user'.$i.'@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'is_admin' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Electronics',
            'Clothing',
            'Home & Kitchen',
            'Books',
            'Sports & Outdoors',
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category,
                'slug' => Str::slug($category),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

class AddressSeeder extends Seeder
{
    public function run(): void
    {
        // Add addresses for each user
        for ($userId = 1; $userId <= 11; $userId++) {
            DB::table('addresses')->insert([
                'user_id' => $userId,
                'address_line' => fake()->streetAddress(),
                'city' => fake()->city(),
                'phone_number' => fake()->phoneNumber(),
                'notes' => fake()->boolean(30) ? fake()->sentence() : null,
                'is_default' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = DB::table('categories')->pluck('id');

        for ($i = 1; $i <= 50; $i++) {
            $name = 'Product ' . $i;

            DB::table('products')->insert([
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => fake()->paragraph(3),
                'price' => fake()->randomFloat(2, 9.99, 999.99),
                'stock_quantity' => fake()->numberBetween(0, 100),
                'image' => fake()->imageUrl(640, 480, 'products', true), // Generates a fake product image URL
                'is_featured' => fake()->boolean(20), // 20% chance to be featured
                'category_id' => $categories->random(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}


class OrderSeeder extends Seeder
{
    public function run(): void
    {
        // Skip admin user (id=1)
        for ($userId = 2; $userId <= 11; $userId++) {
            // Create 1-3 orders per user
            $orderCount = rand(1, 3);
            
            for ($i = 1; $i <= $orderCount; $i++) {
                $orderDate = fake()->dateTimeBetween('-6 months', 'now');

                DB::table('orders')->insert([
                    'user_id' => $userId,
                    'address_id' => DB::table('addresses')
                        ->where('user_id', $userId)
                        ->value('id'),
                    'status' => fake()->randomElement(['pending', 'processing', 'completed', 'cancelled']),
                    'payment_method' => fake()->randomElement(['credit_card', 'paypal', 'bank_transfer', 'cash_on_delivery']),
                    'total_amount' => 0, // Will be updated after order items are added
                    'created_at' => $orderDate,
                    'updated_at' => $orderDate,
                ]);
            }
        }
    }
}

class OrderItemSeeder extends Seeder
{
    public function run(): void
    {
        $orders = DB::table('orders')->get();
        $products = DB::table('products')->get();
        
        foreach ($orders as $order) {
            // Add 1-5 items per order
            $itemCount = rand(1, 5);
            $totalAmount = 0;
            
            // Get random unique products
            $orderProducts = $products->random($itemCount);
            
            foreach ($orderProducts as $product) {
                $quantity = rand(1, 3);
                $price = $product->price;
                $subtotal = $price * $quantity;
                $totalAmount += $subtotal;
                
                DB::table('order_items')->insert([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $price,
                    'created_at' => $order->created_at,
                    'updated_at' => $order->created_at,
                ]);
            }
            
            // Update order total
            DB::table('orders')
                ->where('id', $order->id)
                ->update(['total_amount' => $totalAmount]);
        }
    }
}