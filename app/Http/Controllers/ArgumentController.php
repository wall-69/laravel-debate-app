<?php

namespace App\Http\Controllers;

use App\Models\Argument;
use Illuminate\Http\Request;

class ArgumentController extends Controller
{
    public function index(Request $request)
    {
        return response()->json($request->user()->arguments);
    }
}
