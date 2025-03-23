<?php

namespace App\Http\Controllers;

use App\Models\Argument;
use App\Models\Thesis;
use App\Models\User;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    public function adminStatistics()
    {
        return response()->json([
            "users_amount" => User::count(),
            "theses_amount" => Thesis::count(),
            "arguments_amount" => Argument::count(),
        ]);
    }
}
