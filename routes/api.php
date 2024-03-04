<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ItemsController;

function addResourceRoutes($base, $controller, $except = [])
{
    if (!in_array('index', $except)) {
        Route::get($base, [$controller, 'index'])->name($controller . '.index');
    }

    if (!in_array('show', $except)) {
        Route::get($base . '/{id}', [$controller, 'show'])->name($controller . '.show');
    }

    if (!in_array('store', $except)) {
        Route::post($base, [$controller, 'store'])->name($controller . '.store');
    }

    if (!in_array('update', $except)) {
        Route::post($base . '/{id}', [$controller, 'update'])->name($controller . '.update');
    }

    if (!in_array('destroy', $except)) {
        Route::post($base . '/delete/{id}', [$controller, 'destroy'])->name($controller . '.destroy');
    }
}

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/user', function (Request $request) {
    return User::first();
});

addResourceRoutes('categories', CategoriesController::class);
addResourceRoutes('items', ItemsController::class);