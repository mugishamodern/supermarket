<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'mugishamodern150@gmail.com',
            'password' => Hash::make('Uganda256'),
            'is_admin' => true,
        ]);
    }
}