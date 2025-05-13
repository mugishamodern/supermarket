<?php

namespace App\Http\Controllers;

use App\Models\ContactInquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CustomerServiceController extends Controller
{
    /**
     * Display the customer service page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('customer-service');
    }

    /**
     * Store a new contact inquiry.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:2000',
        ]);

        try {
            ContactInquiry::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'message' => $validated['message'],
            ]);

            // Optionally send an email notification to the admin
            /*
            Mail::to('info@mukorasupermarket.com')->send(
                new \App\Mail\ContactInquiryReceived($validated)
            );
            */

            return response()->json([
                'success' => true,
                'message' => 'Your message has been sent successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while sending your message.'
            ], 500);
        }
    }
}