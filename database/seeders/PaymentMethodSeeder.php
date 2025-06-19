<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    public function run()
    {
        $methods = [
            ['name' => 'Cash on Delivery', 'is_active' => true],
            ['name' => 'Mobile Money', 'is_active' => true],
            ['name' => 'Credit/Debit Card', 'is_active' => true],
        ];

        foreach ($methods as $method) {
            PaymentMethod::firstOrCreate(
                ['name' => $method['name']],
                ['is_active' => $method['is_active']]
            );
        }
    }
}