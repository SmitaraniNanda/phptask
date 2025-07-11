<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('hello');
// });
// Route::get('/api/documentation', function () {
//     return view('vendor.l5-swagger.index');
// });
Route::get('/sanctum/csrf-cookie', function () {
    return response()->json(['csrf' => csrf_token()]);
});

Route::get('/download-invoice', [PDFController::class, 'generatePDF'])->name('download.pdf');
Route::get('/', function () {
    return view('download');
}); 
