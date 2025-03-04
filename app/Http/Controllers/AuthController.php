<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate([
            "email" => "required",
            "password" => "required"
        ]);

        if (auth("web")->attempt($data)) {
            $request->session()->regenerate();

            return response()->json([
                "user" => auth()->user()
            ]);
        }

        throw ValidationException::withMessages([
            "password" => ["Invalid credentials."]
        ]);
    }

    public function logout(Request $request)
    {
        auth("web")->logout();

        $request->session()->invalidate();
        $request->session()->regenerate();

        return response()->json();
    }
}
