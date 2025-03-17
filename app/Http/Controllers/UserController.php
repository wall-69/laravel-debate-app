<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function user(Request $request)
    {
        return response()->json($request->user()->load("admin"));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "name" => "required",
            "surname" => "required",
            "email" => "required|email|unique:users",
            "password" => "required|min:6|confirmed",
            "tos" => "required|accepted",
        ]);

        User::create($data);

        return response()->json();
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            "password" => "required",
            "email" => "sometimes|email|unique:users",
            "new_password" => "sometimes|min:6"
        ]);

        if (Hash::check($data["password"], $user->password)) {
            if ($request->has("email")) {
                $user->update($request->only("email"));
            }

            if ($request->has("new_password")) {
                $user->update([
                    "password" => Hash::make($request->new_password)
                ]);

                /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
                auth("web")->login($user);
            }

            return response()->json($user);
        }

        throw ValidationException::withMessages([
            "password" => "Invalid credentials."
        ]);
    }

    public function destroy(Request $request, User $user)
    {
        $data = $request->validate([
            "password" => "required"
        ]);

        if (Hash::check($data["password"], $user->password)) {
            auth("web")->logout();

            $request->session()->invalidate();
            $request->session()->regenerate();

            $user->delete();

            return response()->json();
        }

        throw ValidationException::withMessages([
            "password" => ["Invalid credentials."]
        ]);
    }
}
