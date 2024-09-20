<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\GroupeController;
use App\Http\Controllers\MembreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/groupes', [GroupeController::class, 'store']);
Route::get('/groupes', [GroupeController::class, 'index']);
Route::get('/groupes/{id}', [GroupeController::class, 'show']);
Route::put('/groupes/{id}', [GroupeController::class, 'update']);
Route::delete('/groupes/{id}', [GroupeController::class, 'destroy']);

Route::post('groupes/{id}/membres', [MembreController::class, 'addMembre']);
Route::delete('/groupes/{id}/membres/{membre_id}', [MembreController::class, 'removeMembre']);
Route::get('/groupes/{id}/membres', [MembreController::class, 'listMembres']);

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');

Route::post('/groupes/{id}/fichiers', [FileController::class, 'upload']);
Route::get('/groupes/{id}/fichiers', [FileController::class, 'list']);



