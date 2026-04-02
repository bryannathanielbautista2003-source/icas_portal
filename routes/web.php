<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\AdminController;

// Redirect home to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route(Auth::user()->role . '.dashboard');
    })->name('dashboard');

    Route::prefix('student')->middleware('role:student')->name('student.')->group(function () {
        Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
        Route::post('/modules/records', [StudentController::class, 'storeModuleRecord'])->name('modules.records.store');
        Route::get('/grades', [StudentController::class, 'grades'])->name('grades');
        Route::get('/classrooms', [StudentController::class, 'classrooms'])->name('classrooms');
        Route::get('/documents', [StudentController::class, 'documents'])->name('documents');
        Route::get('/forum', [StudentController::class, 'forum'])->name('forum');
    });

    Route::prefix('faculty')->middleware('role:faculty')->name('faculty.')->group(function () {
        Route::get('/dashboard', [FacultyController::class, 'dashboard'])->name('dashboard');
        Route::get('/students', [FacultyController::class, 'students'])->name('students');
        Route::get('/grades', [FacultyController::class, 'grades'])->name('grades');
    });

    Route::prefix('admin')->middleware('role:admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/grades', [AdminController::class, 'grades'])->name('grades');
        Route::get('/classrooms', [AdminController::class, 'classrooms'])->name('classrooms');
        Route::get('/documents', [AdminController::class, 'documents'])->name('documents');
        Route::get('/forum', [AdminController::class, 'forum'])->name('forum');
    });
});