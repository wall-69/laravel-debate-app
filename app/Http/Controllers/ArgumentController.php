<?php

namespace App\Http\Controllers;

use App\Models\Argument;
use Illuminate\Http\Request;

class ArgumentController extends Controller
{
    public function argumentById(Request $request, Argument $argument)
    {
        return response()->json($argument->load("thesis")->load("judgement"));
    }

    public function index(Request $request)
    {
        return response()->json($request->user()->arguments->load("thesis"));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "user_id" => "required|exists:users,id",
            "thesis_id" => "required|exists:theses,id",
            "content" => "required|min:30|max:3000"
        ]);

        $argument = Argument::create($data);

        return response()->json($argument);
    }
}
