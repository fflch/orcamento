<?php

use App\Http\Controllers\IndexController;
//use App\Http\Controllers\LoginController;
use App\Http\Controllers\MovimentoController;
use App\Http\Controllers\TipoContaController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\DotOrcamentariaController;
use App\Http\Controllers\ContaController;
use App\Http\Controllers\NotaController;
use App\Http\Controllers\LancamentoController;
use App\Http\Controllers\FicOrcamentariaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UnidadeController;
use App\Http\Controllers\RelatorioController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\selTipoContaController;
use App\Http\Controllers\LancamentoUserController;

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
Route::get('/home_usuario', [LancamentoUserController::class, 'index']);
Route::get('/lancamentos_usuario', [LancamentoUserController::class, 'lancamentos']);
Route::get('/lancamentos_usuario_pdf', [LancamentoUserController::class, 'lancamentos_pdf']);
Route::get('mudaano/{ano}', [IndexController::class, 'mudaAno']);
//Route::get('callback', [LoginController::class, 'handleProviderCallback']);
Route::resource('movimentos', MovimentoController::class);
Route::resource('tipocontas', TipoContaController::class);
Route::resource('areas', AreaController::class);
Route::resource('dotorcamentarias', DotOrcamentariaController::class);
Route::resource('contas', ContaController::class);
Route::get('/contas_por_tipo_de_conta/{tipoconta_id}', [ContaController::class,'contas_por_tipo_de_conta']);
Route::resource('notas', NotaController::class);
Route::post('/lancamentos/{lancamento}/percentual/storePercentual', [LancamentoController::class, 'storePercentual']);
Route::delete('/lancamentos/{lancamento}/destroyPercentual', [LancamentoController::class, 'destroyPercentual']);
Route::resource('lancamentos', LancamentoController::class);
Route::get('/lancamentos_por_conta/{conta}', [ContaController::class,'lancamentos_por_conta']);
Route::resource('ficorcamentarias', FicOrcamentariaController::class);
Route::post('ficorcamentarias/', [FicOrcamentariaController::class, 'store'])->name('ficorcamentarias');
Route::post('/ficorcamentarias/{ficorcamentaria}/cpfo/storeCpfo', [FicOrcamentariaController::class, 'storeCpfo']);
Route::get('/fichas_por_dotacao/{dotorcamentaria}', [DotOrcamentariaController::class,'fichas_por_dotacao']);
Route::resource('usuarios', UserController::class);
Route::delete('/usuarios/{conta}/destroyContaUsuario', [UserController::class, 'destroyContaUsuario']);
Route::post('/usuarios/{usuario}/storeContaUsuario', [UserController::class, 'storeContaUsuario']);
Route::resource('unidades', UnidadeController::class);
Route::post('/contas_usuarios/{usuario}', [UserController::class,'contas_usuarios']);
Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->middleware('can:Administrador');
Route::get('/relatorios', [RelatorioController::class, 'relatorios'])->name('relatorios.index');
Route::get('/relatorios/balancete', [RelatorioController::class, 'balancete'])->name('relatorios.balancete');
Route::get('/relatorios/acompanhamento', [RelatorioController::class, 'acompanhamento'])->name('relatorios.acompanhamento');
Route::get('/relatorios/saldo_contas', [RelatorioController::class, 'saldo_contas'])->name('relatorios.saldo_contas');
Route::get('/relatorios/saldo_projetos_especiais', [RelatorioController::class, 'saldo_projetos_especiais'])->name('relatorios.saldo_projetos_especiais');
Route::get('/relatorios/saldo_dotacoes', [RelatorioController::class, 'saldo_dotacoes'])->name('relatorios.saldo_dotacoes');
Route::get('/relatorios/lancamentos', [RelatorioController::class, 'lancamentos'])->name('relatorios.lancamentos');
Route::get('/relatorios/ficha_orcamentaria', [RelatorioController::class, 'ficha_orcamentaria'])->name('relatorios.ficha_orcamentaria');
Route::post('/getContas',[FicOrcamentariaController::class,'getContas'])->name('contrapartida.getContas');
Route::post('/getLancamentoContas',[LancamentoController::class,'getLancamentoContas'])->name('percentual.getLancamentoContas');
