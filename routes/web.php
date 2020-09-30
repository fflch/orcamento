<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\MovimentoController;
use App\Http\Controllers\TipoContaController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\DotOrcamentariaController;
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

Route::get('/', [IndexController::class, 'index'])->name('home');

Route::resource('movimentos', MovimentoController::class);
Route::resource('tipocontas', TipoContaController::class);
Route::resource('areas', AreaController::class);
Route::resource('dotorcamentarias', DotOrcamentariaController::class);