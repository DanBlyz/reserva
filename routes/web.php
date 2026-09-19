<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\Admin\RolesIndex;
use App\Livewire\Admin\SucursalesIndex;
use App\Livewire\Admin\UsuariosIndex;
use App\Livewire\Servicios\ServiciosIndex;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/servicios', ServiciosIndex::class)->name('services.index');

    // Módulo de Administración (Protegido por permisos y rol Admin)
    Route::middleware('permission:sucursales.ver')->get('/admin/sucursales', SucursalesIndex::class)->name('admin.sucursales');
    Route::middleware('permission:roles.ver')->get('/admin/roles', RolesIndex::class)->name('admin.roles');
    Route::middleware('permission:usuarios.ver')->get('/admin/usuarios', UsuariosIndex::class)->name('admin.usuarios');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
