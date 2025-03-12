<?php

namespace App\Http\Controllers;

use App\Models\Judgement;
use Illuminate\Http\Request;

class JudgementController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            "argument_ulid" => "required|exists:arguments,ulid",
            "content" => "required"
        ]);

        Judgement::create($data);

        return response()->json();
    }
}
