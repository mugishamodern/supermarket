<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function attemptLogin(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (auth()->attempt($validated)) {
            $user = Auth::user();

            // Redirect back to intended URL if available
            $intended = session()->pull('url.intended', null);
            if ($intended && $intended !== route('login')) {
                return redirect()->to($intended)->with('success', 'Login successful!');
            }

            // Redirect based on role
            $redirectPath = $this->getredirectedBasedOnRole($user);

            if (empty($redirectPath)) {
                // Fallback to products page (not properties)
                return redirect()->route('products.index')->with('success', 'Login successful!');
            }

            return redirect()->route($redirectPath)->with('success', 'Login successful!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Get the redirect route based on user role.
     *
     * @param  \App\Models\User  $user
     * @return string
     */
    protected function getredirectedBasedOnRole($user)
    {
        return $user->is_admin ? 'admin.dashboard' : 'products.index';
    }
}