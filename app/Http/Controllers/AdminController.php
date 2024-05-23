<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth; // Importing the Auth facade for authentication

/**
 * AdminController
 */
class AdminController extends Controller
{
    /**
     * loginblade
     *
     * @return
     */
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
        $credentials = $request->only(["email", "password"]);

        if (Auth::attempt($credentials)) {
            return redirect()->route('companies.index')->with('success', 'Logged in...');
        }

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
        Auth::logout();

        return redirect()->route('login');
    }
}
