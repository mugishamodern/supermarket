<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::latest()->get(); // Fetch all feedback
        return view('feedback.index', compact('feedbacks',));
    }

    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'message' => 'required|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // max 2MB
            'rating' => 'required|numeric|min:1|max:5',
        ]);

        // Handle the photo upload
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('feedback_photos', 'public');
        }

        // Create and save the feedback
        Feedback::create([
            'name' => $request->name,
            'location' => $request->location,
            'message' => $request->message,
            'photo' => $photoPath,
            'rating' => $request->rating,
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Your feedback has been submitted successfully!');
    }
    public function create()
{   
    // Fetch categories from your database
    $categories = \App\Models\Category::all(); // Adjust this based on your model name
    return view('feedback.create', compact('categories'));  // Ensure 'feedback.create' is the correct Blade view
}

}
