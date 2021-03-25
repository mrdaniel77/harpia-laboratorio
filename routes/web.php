<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EquipamentoController;
use App\Http\Controllers\ColaboradorController;


Route::get('/', [DashboardController::class, 'index']);

Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes');
Route::get('/clientes/novo', [ClienteController::class, 'novo'])->name('clientes.novo');
Route::get('/clientes/editar/{id}', [ClienteController::class, 'editar'])->name('clientes.editar');
Route::post('/clientes/salvar', [ClienteController::class, 'salvar'])->name('clientes.salvar');
Route::get('/clientes/deletar/{id}', [ClienteController::class, 'deletar'])->name('clientes.deletar');

Route::get('/equipamentos', [EquipamentoController::class, 'index'])->name('equipamentos');
Route::get('/equipamentos/novo', [EquipamentoController::class, 'novo'])->name('equipamentos.novo');
Route::get('/equipamentos/editar/{id}', [EquipamentoController::class, 'editar'])->name('equipamentos.editar');
Route::post('/equipamentos/salvar', [EquipamentoController::class, 'salvar'])->name('equipamentos.salvar');
Route::get('/equipamentos/deletar/{id}', [EquipamentoController::class, 'deletar'])->name('equipamentos.deletar');


Route::get('/colaboradores', [ColaboradorController::class, 'index'])->name('colaboradores');
Route::get('/colaboradores/novo', [ColaboradorController::class, 'novo'])->name('colaboradores.novo');
Route::get('/colaboradores/editar/{id}', [ColaboradorController::class, 'editar'])->name('colaboradores.editar');
Route::post('colaboradores/salvar', [ColaboradorController::class, 'salvar'])->name('colaboradores.salvar');
Route::get('/colaboradores/deletar/{id}', [ColaboradorController::class, 'deletar'])->name('colaboradores.deletar');

