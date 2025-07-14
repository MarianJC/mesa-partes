<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\EstudianteLoginController;
use App\Http\Controllers\Auth\MesaPartesLoginController;
use App\Http\Controllers\MesaPartesController;
use App\Http\Controllers\TramiteController;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\Admin\EstudianteController;
use App\Http\Controllers\Admin\PersonalController;
use App\Http\Controllers\Admin\AdminTramiteController;
use App\Http\Controllers\Admin\PanelGeneralController;
use App\Http\Controllers\SecretariaController;
use App\Http\Controllers\DireccionController;

Route::get('/', function () {
    return view('welcome');
})->name('inicio');

//RUTA PARA EL APARTADO DEL LOGIN DEL ESTUDIANTE//
Route::get('/login/estudiante', function () {
    return view('auth.login-estudiante');
})->name('login.estudiante');

//RUTA PARA EL APARTADO DEL LOGIN DE MESA DE PARTES//
Route::get('/login/mesadepartes', function () {
    return view('auth.login-mesapartes');
})->name('login.mesapartes');

//VISTA DEL FORMULARIO - ESTUDIANTE//
Route::get('/login/estudiante', [EstudianteLoginController::class, 'showLoginForm'])->name('login.estudiante');

//PROCESAR LOGIN - ESTUDIANTE//
Route::post('/login/estudiante', [EstudianteLoginController::class, 'login'])->name('login.estudiante.post');

//LOGOUT
Route::post('/logout/estudiante', [EstudianteLoginController::class, 'logout'])->name('logout.estudiante');

//PANEL DE ESTUDIANTE//
Route::get('/panel-estudiante', function () {
    return view('panel-estudiante');
})->middleware('auth:estudiante')->name('panel-estudiante');

//VISTA DEL LOGIN - MESA DE PARTES//
Route::get('/login/mesapartes', [MesaPartesLoginController::class, 'showLoginForm'])->name('login.mesapartes');

//PROCESAR LOGIN - MESA DE PARTES//
Route::post('/login/mesapartes', [MesaPartesLoginController::class, 'login'])->name('login.mesapartes.post');

//LOGOUT//
Route::post('/logout/mesapartes', [MesaPartesLoginController::class, 'logout'])->name('logout.mesapartes');

//PANEL DE MESA DE PARTES//
Route::get('/panel-mesapartes', function () {
    return view('panel-mesapartes');
})->middleware('auth:mesapartes');

Route::get('/iniciar-tramite/{tipo}', [TramiteController::class, 'mostrarFormulario'])
    ->middleware('auth:estudiante')
    ->name('tramite.formulario');

    //ENVIO//
Route::post('/enviar-tramite', [TramiteController::class, 'enviar'])
    ->middleware('auth:estudiante')
    ->name('tramite.enviar');

Route::get('/tramites-enviados', [TramiteController::class, 'tramitesEnviados'])
    ->middleware('auth:estudiante')
    ->name('tramites.enviados');

Route::get('/tramite/{id}/ver', [TramiteController::class, 'ver'])
    ->name('tramite.ver');

Route::get('/panel-mesapartes', [MesaPartesController::class, 'bandeja'])
    ->name('mesapartes.bandeja');

Route::get('/tramite/revisar/{id}', [TramiteController::class, 'revisar'])
    ->name('mesapartes.revisar');

Route::post('/tramite/{id}/derivar', [TramiteController::class, 'derivar'])
    ->name('tramite.derivar');

Route::post('/tramite/{id}/rechazar', [TramiteController::class, 'rechazar'])
    ->name('tramite.rechazar');

Route::get('/notificaciones', [NotificacionController::class, 'index'])
    ->name('estudiante.notificaciones');

Route::post('/notificaciones/{id}/leer', [NotificacionController::class, 'marcarLeida'])
    ->name('notificacion.leer');

Route::get('/historial-tramites', [MesaPartesController::class, 'historial'])
    ->middleware('auth:mesapartes')
    ->name('mesapartes.historial');

    //ELIMINAR NOTIFICACION//
Route::delete('/notificaciones/{id}', [NotificacionController::class, 'destroy'])->name('notificacion.eliminar');

//RUTA PARA TRAER LOS DATOS//
Route::get('/tramite/detalle/{id}', [TramiteController::class, 'detalle'])
    ->name('tramite.detalle');

//Vista pública para seguimiento SIN login//
Route::get('/', [TramiteController::class, 'formSeguimiento'])->name('inicio');
Route::get('/seguimiento', [TramiteController::class, 'formSeguimiento'])->name('seguimiento.buscar');

Route::get('/tramite/detalle-estudiante/{id}', [TramiteController::class, 'detalleEstudiante'])
    ->middleware('auth:estudiante')
    ->name('tramite.detalle.estudiante');

Route::get('/notificaciones/{id}/ver', [TramiteController::class, 'ver'])->name('notificaciones.ver');

//RUTAS PARA ADMIN//
Route::prefix('admin')->middleware('auth:mesapartes')->group(function () {

    Route::get('/panel', [PanelGeneralController::class, 'index'])->name('admin.panel.index');

    Route::get('/estudiantes', [EstudianteController::class, 'index'])->name('admin.estudiantes.index');
    Route::get('/estudiantes/crear', [EstudianteController::class, 'create'])->name('admin.estudiantes.create');
    Route::post('/estudiantes', [EstudianteController::class, 'store'])->name('admin.estudiantes.store');
    Route::get('/estudiantes/{id}/editar', [EstudianteController::class, 'edit'])->name('admin.estudiantes.edit');
    Route::put('/estudiantes/{id}', [EstudianteController::class, 'update'])->name('admin.estudiantes.update');
    Route::delete('/estudiantes/{id}', [EstudianteController::class, 'destroy'])->name('admin.estudiantes.destroy');
    // ✅ Rutas de personal
    Route::get('/personales', [PersonalController::class, 'index'])->name('admin.personales.index');
    Route::get('/personales/crear', [PersonalController::class, 'create'])->name('admin.personales.create');
    Route::post('/personales', [PersonalController::class, 'store'])->name('admin.personales.store');
    Route::get('/personales/{id}/editar', [PersonalController::class, 'edit'])->name('admin.personales.edit');
    Route::put('/personales/{id}', [PersonalController::class, 'update'])->name('admin.personales.update');
    Route::delete('/personales/{id}', [PersonalController::class, 'destroy'])->name('admin.personales.destroy');

    //RUTA PARA LOS TRAMITES ADMINISTRADOR//

    Route::get('/tramites', [AdminTramiteController::class, 'index'])->name('admin.tramites.index');
    
});

//PANEL SECRETARIA ACADEMICA//
Route::middleware(['auth:mesapartes'])->group(function () {
    Route::get('/panel-secretaria', [SecretariaController::class, 'index'])->name('panel.secretaria');
    Route::get('/tramite/secretaria/{id}/ver', [SecretariaController::class, 'revisar'])->name('secretaria.revisar');
    Route::post('/tramite/secretaria/{id}/atender', [SecretariaController::class, 'atender'])->name('secretaria.atender');
    Route::post('/tramite/secretaria/{id}/derivar', [SecretariaController::class, 'derivar'])->name('secretaria.derivar');
    Route::get('/historial-secretaria', [SecretariaController::class, 'historial'])
    ->name('secretaria.historial');
});

//PANEL DIRECCION ACADEMICA//
Route::middleware(['auth:mesapartes'])->group(function () {
    Route::get('/panel-direccion', [DireccionController::class, 'index'])->name('panel.direccion');
    Route::get('/tramite/direccion/{id}/ver', [DireccionController::class, 'revisar'])->name('direccion.revisar');
    Route::post('/tramite/direccion/{id}/atender', [DireccionController::class, 'atender'])->name('direccion.atender');
    Route::post('/tramite/direccion/{id}/reasignar', [DireccionController::class, 'reasignar'])->name('direccion.reasignar');
    Route::get('/historial-direccion', [DireccionController::class, 'historial'])->name('direccion.historial');

});




