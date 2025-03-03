<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            "name" => "required",
            "email" => "required|email",
            "password" => "required|min:6|confirmation",
            "tos" => "required|accepted",
        ]);
    }
}
