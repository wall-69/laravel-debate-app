<?php

namespace App\Http\Controllers;

use App\Models\Judgement;
use Illuminate\Http\Request;

class JudgementController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            "argument_id" => "required|exists:arguments,id",
            "content" => "required"
        ]);

        Judgement::create($data);

        return response()->json();
    }
}
