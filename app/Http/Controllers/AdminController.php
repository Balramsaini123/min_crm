<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth; // Importing the Auth facade for authentication

class AdminController extends Controller
{
    // Method to return the login view
    public function loginblade()
    {
        return view('admin.login');
    }

    /**
     * Handle user login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Get the email and password from the request
        $credentials = $request->only(["email", "password"]);

        // Attempt to authenticate the user using the provided credentials
        if (Auth::attempt($credentials)) {
            // If authentication successful, redirect to companies index page with success message
            return redirect()->route('companies.index')->with('success', 'Logged in...');
        }

        // If authentication failed, redirect back with error message
        return redirect()->back()->with('success', 'Please provide correct credentials...');
    }

    /**
     * Handle user logout.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        // Logout the authenticated user
        Auth::logout();

        // Redirect to the login page
        return redirect()->route('login');
    }
}
