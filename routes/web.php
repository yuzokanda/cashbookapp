<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CategoryController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
Route::fallback(function () {
	return Inertia::render('Auth/Login');
});

Route::middleware('auth',)->group(function () {
    Route::get('/', [ItemController::class, 'index'])->name('index');
    Route::get('/items', [ItemController::class, 'index'])->name('items.index');
    Route::post('/items', [ItemController::class, 'store'])->name('items.store');
    Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');
    Route::get('/items/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/items/{data}', [ItemController::class, 'getItemsByMonthly'])->name('getItemsByMonthly');
    Route::get('/items/{item}/edit}', [ItemController::class, 'edit'])->name('items.edit');

    Route::get('/items/categories/{category}/edit}', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/items/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::post('/items/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/items/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    // Route::delete('/items/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    Route::put('/items/{item}', [ItemController::class, 'update'])->name('items.update');
    Route::delete('/items/{item}', [ItemController::class, 'destroy'])->name('items.destroy');


});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
