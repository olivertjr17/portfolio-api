<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// 🟢 PUBLIC ROUTES (no auth required)
Route::get('/projects', [ProjectController::class, 'index']); // paginated (admin)
Route::get('/projects/all', [ProjectController::class, 'allProjects']); // all (guest)
Route::get('/projects/all-featured', [ProjectController::class, 'allFeaturedProjects']); // all featured (guest)
Route::get('/projects/{project}', [ProjectController::class, 'show']);

// 🔒 PROTECTED ROUTES (require login)
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/projects', [ProjectController::class, 'store']);
    Route::put('/projects/{project}', [ProjectController::class, 'update']);
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy']);
});
