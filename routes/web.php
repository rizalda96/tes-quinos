<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('app');
});

Route::group(['prefix' => 'student', 'as' => 'student.'], function () {
    Route::get('/', [StudentController::class, 'search'])->name('get');
    Route::post('/store', [StudentController::class, 'store'])->name('store');
    Route::put('/update', [StudentController::class, 'update'])->name('update');
    Route::get('/{id}/detail', [StudentController::class, 'show'])->name('show');
    Route::get('/validate-code', [StudentController::class, 'validateCode'])->name('validate-code');
    Route::delete('/drop', [StudentController::class, 'drop'])->name('drop');
});
