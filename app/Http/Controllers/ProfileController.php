<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function show(Request $request): View
    {
        // Get cached categories to avoid redundant queries
        $categories = Cache::remember('categories', 3600, function () {
            return \App\Models\Category::select('id', 'name', 'slug')->get();
        });
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Profile', 'url' => route('user.profile')],
        ];
        return view('profile.user', [
            'user' => $request->user(),
            'categories' => $categories,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    /**
     * Display the user's profile edit form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Create user profile view.
     */
    public function create()
    {   
        // Get cached categories to avoid redundant queries
        $categories = Cache::remember('categories', 3600, function () {
            return \App\Models\Category::select('id', 'name', 'slug')->get();
        });
        
        return view('profile.user', compact('categories'));  
    }
}
