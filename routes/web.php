<?php

use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InboundController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\OutboundController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/location', function () {
    return view('location.locationCreate');
})->name('location');
Route::post('/location', [LocationController::class, 'store'])->name('location.store');
Route::get('location/download-invalid', [LocationController::class, 'downloadInvalid'])->name('location.downloadInvalid');
Route::get('/location/list', [LocationController::class, 'index'])->name('location.list');
Route::get('/location/{id}/edit', [LocationController::class, 'edit'])->name('location.edit');
Route::put('/location/{id}/edit', [LocationController::class, 'update'])->name('location.update');



Route::get('/inbounds',function(){
    return view('Inbound.Create');})->name('inbounds');
Route::post('inbounds/import', [InboundController::class, 'store'])->name('inbounds.store');
Route::get('inbounds/download-invalid', [InboundController::class, 'downloadInvalid'])->name('inbounds.downloadInvalid');
Route::get('/inbounds/list', [InboundController::class, 'index'])->name('inbounds.list');
Route::get('/inbounds/{id}/edit', [InboundController::class, 'edit'])->name('inbounds.edit');
Route::put('/inbounds/{id}/edit', [InboundController::class, 'update'])->name('inbounds.update');

Route::get('/outbounds', [OutboundController::class, 'create'])->name('outbounds.gg');

Route::get('/outbounds/list', [OutboundController::class, 'index'])->name('outbounds.list');
Route::post('/outbounds/import', [OutboundController::class, 'store'])->name('outbounds.store');
Route::get('/outbounds/download-invalid', [OutboundController::class, 'downloadInvalid'])->name('outbounds.downloadInvalid');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/export-users', function () {
    return Excel::download(new UsersExport, 'users.csv');
}
);


require __DIR__.'/auth.php';
