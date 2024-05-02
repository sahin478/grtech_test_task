<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

Route::get('/daily-quotes', function (Request $request) {
    $response = Http::withOptions([
        'verify' => false, // Disable SSL verification
    ])->get('https://zenquotes.io/api/quotes', [
        'count' => 50,
    ]);
    return $response->json();
});
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
