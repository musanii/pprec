<?php

use App\Http\Controllers\Admin\AcademicYearController;
use App\Http\Controllers\Admin\ClassSubjectController;
use App\Http\Controllers\Admin\SchoolClassController;
use App\Http\Controllers\Admin\StreamController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\StudentStatusController;
use App\Http\Controllers\Admin\StudentTransferController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\TeacherAssignmentController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\TermController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// students module
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('students', StudentController::class)->only(['index', 'create', 'store', 'edit', 'update']);
    Route::post('students/{student}/transfer', [StudentTransferController::class, 'store'])->name('students.transfer');
    Route::patch('students/{student}/status', [StudentStatusController::class, 'update'])->name('students.status');

    Route::resource('teachers', TeacherController::class)->except(['show']);
    Route::patch('teachers/{teacher}/status', [TeacherController::class, 'status'])
        ->name('teachers.status');

    Route::get('teachers/{teacher}/assignments', [TeacherAssignmentController::class, 'edit'])->name('teachers.assignments.edit');
    Route::post('teachers/{teacher}/assignments', [TeacherAssignmentController::class, 'update'])
        ->name('teachers.assignments.update');

    // Academics routes
    Route::resource('classes', SchoolClassController::class)->except(['show']);
    Route::resource('streams', StreamController::class)->except(['show']);

    Route::resource('academic-years', AcademicYearController::class)->except('show');
    Route::patch('academic-years/{academic_year}/activate', [AcademicYearController::class, 'activate'])
        ->name('academic-years.activate');

    Route::resource('terms', TermController::class)->except(['show']);
    Route::patch('terms/{term}/activate', [TermController::class, 'activate'])
        ->name('terms.activate');

    Route::resource('subjects', SubjectController::class)->except('show');
    Route::patch('subjects/{subject}/activate', [SubjectController::class, 'activate'])->name('subjects.activate');

    Route::get('classes/{class}/subjects', [ClassSubjectController::class, 'edit'])->name('classes.subjects.edit');
    Route::post('classes/{class}/subjects', [ClassSubjectController::class, 'update'])->name('classes.subjects.update');

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
