<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/me', [AuthController::class, 'me']);
Route::middleware('auth:api')->get('/user', function (Request $request) {
  return $request->user();
});

//  login register
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

/* Authors Books*/
// public
Route::get('/books', [BookController::class, 'index']);
Route::get('/books/{id}', [BookController::class, 'show']);
Route::get('/books/search/{title}', [BookController::class, 'search']);

Route::get('/authors', [AuthorController::class, 'index']);
Route::get('/authors/{id}', [AuthorController::class, 'show']);
Route::get('/authors/search/{name}', [AuthorController::class, 'search']);

// protected
Route::middleware(['auth:sanctum'])->group(function () {
  Route::post('/books', [BookController::class, 'store']);
  Route::put('/books/{id}', [BookController::class, 'update']);
  Route::delete('/books/{id}', [BookController::class, 'destroy']);

  Route::post('/authors', [AuthorController::class, 'store']);
  Route::put('/authors/{id}', [AuthorController::class, 'update']);
  Route::delete('/authors/{id}', [AuthorController::class, 'destroy']);
  Route::post('/logout', [AuthController::class, 'logout']);
});