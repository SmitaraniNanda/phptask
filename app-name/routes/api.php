<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\SwaggerController;

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

// Route::post('/login', [AuthController::class, 'login'])->middleware('validate.login');
// Route::get('/welcome', [AuthController::class, 'welcome']);



// Public login route
Route::post('/login', [AuthController::class, 'login']);

// Protected route for file upload (requires auth)
Route::middleware('auth:sanctum')->post('/upload', [FileUploadController::class, 'upload']);

// Sample public route
Route::get('/sample', [SwaggerController::class, 'sample']);

// Optionally add Swagger documentation route (optional if already handled via config)
// Route::get('/documentation', function () {
//     return view('vendor.l5-swagger.index');
// });

