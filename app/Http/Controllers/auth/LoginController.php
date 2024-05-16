<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view("auth.login", ["title" => "Login"]);
    }
    public function auth(Request $request)
    {

        $request->validate([
            "username" => "required|min:4",
            "password" => "required|min:4"
        ]);

        $credentials = $request->only('username', 'password');

        try {
            if (Auth::attempt($credentials)) {
                if (auth()->user()->role == 'admin') {
                    return redirect()->intended('/home');
                }

                if (auth()->user()->role == 'moderator') {
                    return redirect()->intended('/moderator');
                }
            }
        } catch (\Exception $e) {

        }

        return back()->withErrors([
            'credentials' => 'Invalid username or password.',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route("login");
    }



}
