<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\SalesforceController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Public Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected Route: Get Authenticated User
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Protected Route: Upload file (Gmail users only)
Route::post('/upload', [FileUploadController::class, 'upload'])->middleware(['auth:sanctum', 'gmail.only']);

// Protected Route: Gmail-only dashboard
Route::middleware(['auth:sanctum', 'gmail.only'])->get('/dashboard', function () {
    return response()->json([
        'message' => 'Welcome to the Gmail-only dashboard!',
    ]);
});
//Route::get('/salesforce/leads', [SalesforceController::class, 'getLeads']);

