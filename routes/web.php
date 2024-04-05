<?php

use App\Http\Controllers\listController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/listtodo',[listController::class,'index']);
Route::post('/listtodo',[listController::class,'store']);
Route::get('/listtodo',[listController::class,'show']);
Route::get('/listtodo/{id}/delete',[listController::class,'delete']);
Route::get('/listtodo/{id}/edit',[listController::class,'edit']);
Route::get('/listtodo/{id}',[listController::class,'uploadpage'])->name('subpage');
Route::post('/listtodo/{id}/update',[listController::class,'update']);