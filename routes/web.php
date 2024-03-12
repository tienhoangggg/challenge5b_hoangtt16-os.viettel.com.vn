<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\ChatBoxController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\RiddleController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/login', [AuthController::class, 'index']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/infoUser/{id}', [InfoUserController::class, 'index'])->name('infoUser');
Route::get('/editInfoUser/{id}', [InfoUserController::class, 'edit'])->name('editInfoUser');
Route::post('/editInfoUser/{id}', [InfoUserController::class, 'update'])->name('updateInfoUser');
Route::get('/chatBox/{id}', [ChatBoxController::class, 'index'])->name('chatBox');
Route::post('/chatBox/{id}', [ChatBoxController::class, 'send'])->name('sendChat');
Route::post('/editMessage', [ChatBoxController::class, 'edit'])->name('editMessage');
Route::post('/deleteMessage', [ChatBoxController::class, 'delete'])->name('deleteMessage');
Route::get('/assignment', [AssignmentController::class, 'index'])->name('assignment');
Route::post('/assignment', [AssignmentController::class, 'create'])->name('assignment.create');
Route::get('/assignmentDetail/{id}', [AssignmentController::class, 'detail'])->name('assignment.detail');
Route::post('/assignmentDetail/{id}', [AssignmentController::class, 'submit'])->name('assignment.submit');
Route::get('/download/{id}', [DownloadController::class, 'download'])->name('download');
Route::get('/riddle', [RiddleController::class, 'index'])->name('riddle');
Route::post('/riddle', [RiddleController::class, 'create'])->name('riddle.create');
Route::get('/riddleDetail/{id}', [RiddleController::class, 'detail'])->name('riddle.detail');
Route::post('/riddleDetail/{id}', [RiddleController::class, 'submit'])->name('riddle.submit');