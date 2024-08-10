<?php

use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Route;


Route::get('/', [WebController::class, 'index'])->name('index');
Route::post('/', [WebController::class, 'store'])->name('store');
Route::delete('/{todo}', [WebController::class, 'destroy'])->name('destroy');
Route::patch('/{todo}', [WebController::class, 'update'])->name('update');
