<?php

use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LocationController;

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
