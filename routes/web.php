<?php

use App\Http\Controllers\JobController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\IsAdminMiddleware;
use App\Http\Middleware\IsAdminOrUserMiddleware;
use App\Livewire\JobAssign;
use App\Livewire\ProjectSearch;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return view('welcome');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/users', [UserController::class, 'index'])->name('users.index')->middleware(IsAdminMiddleware::class);
    Route::get('/users/{user_id}/assigned', [UserController::class, 'show'])->name('users.show')->middleware(IsAdminOrUserMiddleware::class);

    Route::get('/home', function () {
        $projects = DB::table('projects')->get();
        return view('home', ['projects' => $projects]);
    })->name('home');

    Route::get('projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('projects/create', [ProjectController::class, 'create'])->name('projects.create')->middleware(IsAdminMiddleware::class);
    Route::get('projects/{project_id}', [ProjectController::class, 'show'])->name('projects.show');
    Route::get('projects/{project_id}/edit', [ProjectController::class, 'edit'])->name('projects.edit')->middleware(IsAdminMiddleware::class);
    Route::delete('projects/{project_id}/delete', [ProjectController::class, 'destroy'])->name('projects.destroy')->middleware(IsAdminMiddleware::class);

    Route::get('projects/{project_id}/tasks/create', [TaskController::class, 'create'])->name('tasks.create')->middleware(IsAdminMiddleware::class);
    Route::get('projects/{project_id}/tasks/{task_id}', [TaskController::class, 'show'])->name('tasks.show');
    Route::get('projects/{project_id}/tasks/{task_id}/edit', [TaskController::class, 'edit'])->name('tasks.edit')->middleware(IsAdminMiddleware::class);
    Route::delete('projects/{project_id}/tasks/{task_id}/delete', [TaskController::class, 'destroy'])->name('tasks.destroy')->middleware(IsAdminMiddleware::class);

    Route::get('projects/tasks/jobs/create', [JobController::class, 'create'])->name('jobs.create')->middleware(IsAdminMiddleware::class);
    Route::get('projects/{project_id}/tasks/{task_id}/jobs/{job_id}/edit', [JobController::class, 'edit'])->name('jobs.edit')->middleware(IsAdminMiddleware::class);
    Route::delete('projects/{project_id}/tasks/{task_id}/jobs/{job_id}/delete', [JobController::class, 'destroy'])->name('jobs.destroy')->middleware(IsAdminMiddleware::class);
});

require __DIR__ . '/auth.php';
