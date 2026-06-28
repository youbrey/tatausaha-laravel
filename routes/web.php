<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PersonelController;
use App\Http\Controllers\Surat\PerjalananDinasController;
use App\Http\Controllers\Surat\UndanganController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('dashboard'));

Auth::routes(); // login, register, password reset (dari laravel/ui)

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ─── Personel ───────────────────────────────────────────
    Route::get('/personel', [PersonelController::class, 'index'])->name('personel.index');
    Route::post('/personel/dprd', [PersonelController::class, 'storeDprd'])->name('personel.dprd.store');
    Route::post('/personel/asn', [PersonelController::class, 'storeAsn'])->name('personel.asn.store');
    Route::delete('/personel/dprd/{personel}', [PersonelController::class, 'destroyDprd'])->name('personel.dprd.destroy');
    Route::delete('/personel/asn/{personel}', [PersonelController::class, 'destroyAsn'])->name('personel.asn.destroy');

    // ─── Surat Perjalanan Dinas (Surat Tugas + SPPD) ───────
    Route::prefix('surat/perjalanan-dinas')->name('surat.perjalanan-dinas.')->group(function () {
        Route::get('/create', [PerjalananDinasController::class, 'create'])->name('create');
        Route::post('/', [PerjalananDinasController::class, 'store'])->name('store');
        Route::get('/{surat}/preview', [PerjalananDinasController::class, 'preview'])->name('preview');
        Route::get('/{surat}/surat-tugas', [PerjalananDinasController::class, 'generateSuratTugas'])->name('surat-tugas');
        Route::get('/{surat}/sppd', [PerjalananDinasController::class, 'generateSppd'])->name('sppd');
    });

    // ─── Surat Undangan ─────────────────────────────────────
    Route::prefix('surat/undangan')->name('surat.undangan.')->group(function () {
        Route::get('/create', [UndanganController::class, 'create'])->name('create');
        Route::post('/', [UndanganController::class, 'store'])->name('store');
        Route::get('/{surat}/preview', [UndanganController::class, 'preview'])->name('preview');
        Route::get('/{surat}/generate', [UndanganController::class, 'generate'])->name('generate');
    });
});
