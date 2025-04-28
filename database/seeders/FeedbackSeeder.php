<?php

namespace Database\Seeders;

use App\Models\Feedback;
use Illuminate\Database\Seeder;

class FeedbackSeeder extends Seeder
{
    public function run()
    {
        Feedback::create([
            'name' => 'Jane Doe',
            'location' => 'Kasese Town',
            'message' => 'I love shopping at Mukora Supermarket. Their products are always fresh, and the staff is incredibly helpful. The online ordering system is so convenient!',
            'photo' => '/images/customer1.jpg',
            'rating' => 5,
        ]);

        Feedback::create([
            'name' => 'John Smith',
            'location' => 'Kisinga',
            'message' => 'The online delivery service is a game-changer! Fast and reliable with excellent customer service.',
            'photo' => '/images/customer2.jpg',
            'rating' => 4.5,
        ]);

        Feedback::create([
            'name' => 'Sarah Johnson',
            'location' => 'Kilembe',
            'message' => 'The variety of products is impressive. I can find everything from local produce to imported goods.',
            'photo' => '/images/customer3.jpg',
            'rating' => 5,
        ]);

        Feedback::create([
            'name' => 'Michael Kiiza',
            'location' => 'Bwera',
            'message' => 'Their loyalty program is excellent - I have saved so much money with the points system!',
            'photo' => '/images/customer4.jpg',
            'rating' => 5,
        ]);
    }
}
