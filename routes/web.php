<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IconController;
use App\Http\Livewire\Icons\Index as IconIndex;

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
    return view('welcome');
});

Route::group([
    'middleware' => ['auth:sanctum', 'verified']
], function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::group([
        'prefix' => 'icons'
    ], function () {
        Route::get('/', IconIndex::class)->name('icons.index');
        Route::get('/create', [IconController::class, 'create'])->name('icons.create');
        Route::post('/', [IconController::class, 'store'])->name('icons.store');
        Route::get('/{icon}/edit', [IconController::class, 'edit'])->name('icons.edit');
        Route::patch('/{icon}', [IconController::class, 'update'])->name('icons.update');
    });
});
