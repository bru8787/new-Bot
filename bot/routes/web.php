<?php

use App\Http\Controllers\BotController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::prefix('/')->middleware(['auth','isAdmin'])->group(function () {

Route::get('importData', [BotController::class, 'importData'])->name('importData');
Route::get('create', [BotController::class, 'create'])->name('create');
Route::get('update/{id}', [BotController::class, 'update'])->name('update');
Route::get('edit/{id}', [BotController::class, 'edit'])->name('edit');
Route::post('store', [BotController::class, 'store'])->name('store');
Route::get('show', [BotController::class, 'show'])->name('show');
Route::get('', [HomeController::class, 'index'])->name('/');
});

Auth::routes();
