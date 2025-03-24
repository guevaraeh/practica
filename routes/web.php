<?php

use App\Http\Controllers\TeacherController;
use App\Http\Controllers\AssistanceTeacherController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/teacher', [TeacherController::class, 'index'])->name('teacher');
Route::get('/teacher/create', [TeacherController::class, 'create'])->name('teacher.create');
Route::post('/teacher/store', [TeacherController::class, 'store'])->name('teacher.store');
//Route::get('/teacherajaxshow/', [TeacherController::class, 'ajaxshow'])->name('teacherajaxshow');
Route::get('/teacher/{teacher}', [TeacherController::class, 'show'])->name('teacher.show');

Route::get('/assistanceteacher', [AssistanceTeacherController::class, 'index'])->name('assistance_teacher');
Route::get('/assistanceteacher/create', [AssistanceTeacherController::class, 'create'])->name('assistance_teacher.create');
Route::post('/assistanceteacher/store', [AssistanceTeacherController::class, 'store'])->name('assistance_teacher.store');
