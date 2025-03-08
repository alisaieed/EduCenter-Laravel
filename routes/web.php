<?php

use App\Http\Controllers\StudentController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentController;


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
Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
Route::delete('students/{student}/remove-course/{course}', [StudentController::class, 'removeCourse'])->name('students.removeCourse');
Route::post('/payments/{id}/refund', [PaymentController::class, 'refund'])->name('payments.refund');
Route::post('/instructors/{instructor}/assign-department', [InstructorController::class, 'assignDepartment'])->name('instructors.assignDepartment');
Route::delete('/instructors/{instructor}/unassign-department/{department}', [InstructorController::class, 'unassignDepartment'])->name('instructors.unassignDepartment');
Route::post('/instructors/{instructor}/assign-course', [InstructorController::class, 'assignCourse'])
    ->name('instructors.assignCourse');

Route::delete('/instructors/{instructor}/unassign-course/{course}', [InstructorController::class, 'unassignCourse'])
    ->name('instructors.unassignCourse');
