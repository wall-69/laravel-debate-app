<?php

use Illuminate\Support\Facades\Route;

// Vue handles routing
Route::get("/{vue_capture?}", function () {
    return view("index");
})->where("vue_capture", "[\/\w\.-]*");
