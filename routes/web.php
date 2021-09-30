<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MovimentoController;
use App\Http\Controllers\TipoContaController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\DotOrcamentariaController;
use App\Http\Controllers\ContaController;
use App\Http\Controllers\NotaController;
use App\Http\Controllers\LancamentoController;
use App\Http\Controllers\FicOrcamentariaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContaUsuarioController;
use App\Http\Controllers\UnidadeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\selTipoContaController;

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
Route::get('/home', [IndexController::class, 'index']);

Route::get('login', [LoginController::class, 'redirectToProvider']);
Route::get('callback', [LoginController::class, 'handleProviderCallback']);
Route::post('logout', [LoginController::class, 'logout']);

Route::resource('movimentos', MovimentoController::class);
Route::resource('tipocontas', TipoContaController::class);
Route::resource('areas', AreaController::class);
Route::resource('dotorcamentarias', DotOrcamentariaController::class);
Route::resource('contas', ContaController::class);
Route::get('/contas_por_tipo_de_conta/{tipoconta_id}', [ContaController::class,'contas_por_tipo_de_conta']);
Route::resource('notas', NotaController::class);
Route::resource('lancamentos', LancamentoController::class);
//Route::post('/ficorcamentarias', [FicOrcamentariaController::class,'store']);
Route::resource('ficorcamentarias', FicOrcamentariaController::class);
Route::post('/ficorcamentarias/cpfo', [FicOrcamentariaController::class,'cpfo']);
Route::resource('usuarios', UserController::class);
Route::resource('contausuarios', ContaUsuarioController::class);
Route::resource('unidades', UnidadeController::class);

Route::post('/contas_usuarios/{usuario}', [UserController::class,'contas_usuarios']);

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->middleware('can:Administrador');

Route::get('seltipoconta', [selTipoContaController::class, 'seltipoconta']);
