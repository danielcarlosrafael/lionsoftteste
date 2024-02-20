<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\TasksController;
use Illuminate\Support\Facades\Mail;
use App\Mail\TaskCreatedMail;
use App\Models\Task;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('categories', CategoriesController::class);
    Route::resource('tasks', TasksController::class);
});

Route::get('/test-email', function () {
    $item = Task::findOrFail(9);
    Mail::to('danielcarlossr1@gmail.com')->send(new TaskCreatedMail($item));
    return "E-mail enviado com sucesso!";
});

require __DIR__.'/auth.php';
