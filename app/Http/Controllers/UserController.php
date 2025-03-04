<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function user(Request $request)
    {
        return response()->json($request->user());
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
}
