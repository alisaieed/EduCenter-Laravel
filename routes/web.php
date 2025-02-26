<?php

use App\Http\Controllers\StudentController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\DashboardController;


Route::resource('students', StudentController::class);
Route::resource('instructors', InstructorController::class);
Route::resource('courses', CourseController::class);
Route::resource('departments', DepartmentController::class);
Route::resource('certificates', CertificateController::class);
Route::get('students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');

Route::get('/departments/{id}/edit', [DepartmentController::class, 'edit'])->name('departments.edit');
Route::put('/departments/{id}', [DepartmentController::class, 'update'])->name('departments.update');
Route::put('/students/{id}/updateCourses', [StudentController::class, 'updateCourses'])->name('students.updateCourses');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
