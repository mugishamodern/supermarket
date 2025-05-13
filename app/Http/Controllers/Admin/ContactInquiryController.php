<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactInquiry;
use App\Mail\ContactInquiryReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactInquiryController extends Controller
{
    /**
     * Display a listing of contact inquiries.
     */
    public function index(Request $request)
    {
        $query = ContactInquiry::orderBy('created_at', 'desc');

        // Apply status filter if provided
        if ($request->has('status') && in_array($request->query('status'), ['pending', 'replied'])) {
            $query->where('status', $request->query('status'));
        }

        $inquiries = $query->paginate(10);

        return view('admin.contact-inquiries.index', compact('inquiries'));
    }

    /**
     * Display the specified contact inquiry.
     */
    public function show(ContactInquiry $contactInquiry)
    {
        return view('admin.contact-inquiries.show', compact('contactInquiry'));
    }

    /**
     * Send a reply to the contact inquiry.
     */
    public function reply(Request $request, ContactInquiry $contactInquiry)
    {
        $validated = $request->validate([
            'reply' => 'required|string|max:5000',
        ]);

        try {
            // Send email reply
            Mail::to($contactInquiry->email)->send(
                new ContactInquiryReply($contactInquiry, $validated['reply'])
            );

            // Update inquiry status
            $contactInquiry->update([
                'status' => 'replied',
                'replied_at' => now(),
            ]);

            return redirect()->route('admin.contact-inquiries.show', $contactInquiry)
                ->with('success', 'Reply sent successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['reply' => 'Failed to send reply. Please try again.']);
        }
    }
}