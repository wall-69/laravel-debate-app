<?php

namespace App\Http\Controllers;

use App\Models\Argument;
use Illuminate\Http\Request;

class ArgumentController extends Controller
{
    public function argumentByid(Request $request, Argument $argument)
    {
        return response()->json($argument->with("thesis"));
    }

    public function index(Request $request)
    {
        return response()->json($request->user()->arguments->load("thesis"));
    }
}
