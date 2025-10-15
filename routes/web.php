<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\TodosController;
 
//Action correspondant au form de la vue (donc POST) et appel de la fonction saveTodo du controller
// Route concernant les todos
Route::get('/', [TodosController::class, 'liste'])->name('todo.liste');
Route::post('/action/add', [TodosController::class, 'saveTodo'])->name('todo.save');
Route::get('/action/done/{id}' , [TodosController::class, 'markAsDone'])->name('todo.done');
Route::get('/action/delete/{id}', [TodosController::class, 'deleteTodo'])->name('todo.delete');
Route::get('/action/lower/{id}', [TodosController::class,  'lowerPriority'])->name('todo.lower');
Route::get('/action/raise/{id}', [TodosController::class, 'raisePriority'])->name('todo.raise');

// Route concernant les pages
Route::get('/compteur', [TodosController::class, 'viewCompteur'])->name('todo.compteur');
Route::get('/about', [TodosController::class, 'viewAPropos'])->name('todo.about');


// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';
