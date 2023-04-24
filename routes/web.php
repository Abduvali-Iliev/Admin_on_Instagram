<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [PostController::class, 'index']);
Route::resource('posts', PostController::class)->middleware('auth')->except('show');
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store')->middleware('auth');
Route::resource('comments', CommentController::class)->except('index', 'show', 'create', 'store');
Route::get('/profile', [ProfileController::class, 'index'])->name('profile')->middleware('auth');
Route::post('/another-profile/follow', [FollowController::class, 'store'])->name('follow')->middleware('auth');
Route::delete('/another-profile/unfollow', [FollowController::class, 'destroy'])->name('unfollow')->middleware('auth');
Route::post('/like', [LikeController::class, 'store'])->name('like')->middleware('auth');
Route::delete('/unlike', [LikeController::class, 'destroy'])->name('unlike')->middleware('auth');
Auth::routes();

