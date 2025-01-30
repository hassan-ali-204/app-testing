<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use phpDocumentor\Reflection\Location;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::get('/test', function () {
    return 'Test Page';
});


Route::middleware('guest:admin')->prefix('admin')->group(function () {
Route::get('/register', [AdminController::class, 'create']);
Route::post('logout', [AdminController::class, 'logout'])->name('admin.logout');
Route::get('/login', [AdminController::class, 'login'])->name('admin.login');
Route::post('/register', [AdminController::class, 'store'])->name('admin.register');

});

Route::get('admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard')->middleware(['auth:admin']);



Route::get('test', function (\Illuminate\Http\Request $request) {
    return 'dfsd';
});
