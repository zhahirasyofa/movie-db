<?php

use App\Http\Middleware\RoleAdmin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MovieController;


// Route::get('/', function () {
//     return view('welcome');
// });


//Route::get('/', [MovieController::class, 'index'])->name('movies.index');
//Route::get('/search', [MovieController::class, 'search'])->name('movies.search');

Route::get('/', [MovieController::class, 'index']);
// return view('welcome');


Route::get('/movie/{id}/{slung}', [MovieController::class, 'detail_movie']);

Route::get('/search', [MovieController::class, 'search'])->name('movies.search');
Route::get('/movies/{id}/edit', [MovieController::class, 'edit'])->middleware('auth', RoleAdmin::class)->name('movie.edit');

Route::get('/movie/create', [MovieController::class, 'create'])->middleware('auth');

Route::post('/movie/store', [MovieController::class, 'store'])->middleware('auth');

Route::get('login', [AuthController::class, 'formLogin'])->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/admin/movies', [MovieController::class, 'showMovies'])->name('admin.movies.list');

Route::resource('movies', MovieController::class);
