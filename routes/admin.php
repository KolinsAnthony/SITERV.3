<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\ProgramaController;
use App\Http\Controllers\Admin\RubroController;
use App\Http\Controllers\Admin\EstudianteController;
use App\Http\Controllers\Admin\ComprobanteController;
use App\Http\Controllers\Admin\BuscarController;
use App\Http\Controllers\Admin\ReporteController; 
use App\Http\Controllers\Admin\FiltrarController;


Route::post('estudiantes/importar', [EstudianteController::class, 'importar'])->name('estudiantes.importar');

Route::resource('home', HomeController::class)->only(['index','edit','update'])->names('admin.home');
Route::resource('usuario', UserController::class)->only(['index', 'store', 'update', 'destroy'])->names('admin.usuario')->middleware('can:admin.usuario.index');
Route::resource('programa', ProgramaController::class)->only(['index','store','update','destroy'])->names('admin.programa');
Route::resource('rubro', RubroController::class)->only(['index','store','update','destroy'])->names('admin.rubro');
Route::resource('estudiante', EstudianteController::class)->only(['index','store','update','destroy'])->names('admin.estudiante');
Route::resource('comprobante', ComprobanteController::class)->only(['index','store','update','destroy'])->names('admin.comprobante');
Route::get('/admin/buscar-estudiante/{dni}', [BuscarController::class, 'buscarEstudiante'])->name('admin.buscarEstudiante');
Route::get('reports/print/{id}', [ReporteController::class, 'printReport'])->name('admin.reports.print');
Route::post('/filtrar', [FiltrarController::class, 'procesarFormulario'])->name('filtro.buscar');
Route::get('/filtro-reportes', [ComprobanteController::class, 'generateReport'])->name('filtro-reportes');
