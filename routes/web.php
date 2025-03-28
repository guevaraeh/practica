<?php

use App\Http\Controllers\TeacherController;
use App\Http\Controllers\AssistanceTeacherController;
use App\Http\Controllers\PeriodController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    //return view('welcome');
    return redirect(route('assistance_teacher.create'));
});

Route::get('/teacher', [TeacherController::class, 'index'])->name('teacher');
Route::get('/teacher/create', [TeacherController::class, 'create'])->name('teacher.create');
Route::post('/teacher/store', [TeacherController::class, 'store'])->name('teacher.store');
Route::get('/teacher/{teacher}', [TeacherController::class, 'show'])->name('teacher.show');
Route::delete('/teacher/{teacher}/destroy', [TeacherController::class, 'destroy'])->name('teacher.destroy');

Route::get('/assistanceteacher', [AssistanceTeacherController::class, 'index'])->name('assistance_teacher');
Route::get('/assistanceteacher/create', [AssistanceTeacherController::class, 'create'])->name('assistance_teacher.create');
Route::post('/assistanceteacher/confirm', [AssistanceTeacherController::class, 'confirm'])->name('assistance_teacher.confirm');
Route::post('/assistanceteacher/store', [AssistanceTeacherController::class, 'store'])->name('assistance_teacher.store');
Route::get('/assistanceteacher/{assistanceTeacher}', [AssistanceTeacherController::class, 'show'])->name('assistance_teacher.show');
Route::get('/assistanceteacher/{assistanceTeacher}/edit', [AssistanceTeacherController::class, 'edit'])->name('assistance_teacher.edit');
Route::put('/assistanceteacher/{assistanceTeacher}/update', [AssistanceTeacherController::class, 'update'])->name('assistance_teacher.update');
Route::delete('/assistanceteacher/{assistance_teacher}/destroy', [AssistanceTeacherController::class, 'destroy'])->name('assistance_teacher.destroy');

Route::get('/period', [PeriodController::class, 'index'])->name('period');