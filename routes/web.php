<?php

use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\StudentStatusController;
use App\Http\Controllers\Admin\StudentTransferController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

//students module
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('students', StudentController::class)->only(['index', 'create', 'store','edit','update']);
    Route::post('students/{student}/transfer',[StudentTransferController::class,'store'])->name('students.transfer');
    Route::patch('students/{student}/status',[StudentStatusController::class,'update'])->name('students.status');

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
