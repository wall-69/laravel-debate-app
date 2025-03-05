<?php

namespace App\Http\Controllers;

use App\Models\Thesis;
use Illuminate\Http\Request;

class ThesisController extends Controller
{
    public function random(Request $request)
    {
        $usedTheses = $request->user()->theses;

        $theses = Thesis::all()->diff($usedTheses);

        return response()->json($theses->random());
    }
}
