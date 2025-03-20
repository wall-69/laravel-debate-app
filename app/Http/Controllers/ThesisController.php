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

    public function index()
    {
        return response()->json(Thesis::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "content" => "required|min:10|unique:theses,content"
        ]);

        $thesis = Thesis::create($data);

        return response()->json($thesis);
    }

    public function update(Request $request, Thesis $thesis)
    {
        $data = $request->validate([
            "content" => "required|min:10"
        ]);

        $thesis->update($data);

        return response()->json();
    }

    public function destroy(Thesis $thesis)
    {
        $thesis->delete();

        return response()->json();
    }
}
