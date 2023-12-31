<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

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

//Route::get('/posts', [PostController::class,'index'])->name('post.index');
//Route::get('/posts/create', [PostController::class,'create'])->name('post.create');
//
//Route::post('/posts/create', [PostController::class,'store'])->name('post.store');
//Route::get('/posts/{post}', [PostController::class,'show'])->name('post.show');
//Route::get('/posts/{post}/edit', [PostController::class,'edit'])->name('post.edit');
//Route::patch('/posts/{post}', [PostController::class,'update'])->name('post.update');
//Route::delete('/posts/{post}', [PostController::class,'destroy'])->name('post.delete');

Route::group(['namespace'=>'App\Http\Controllers\Post'], function(){
    Route::get('/posts', 'IndexController' )->name('post.index');
    Route::get('/posts/create', 'CreateController')->name('post.create');
    Route::post('/posts', 'StoreController')->name('post.store');
    Route::get('/posts/{post}', 'ShowController')->name('post.show');
    Route::get('/posts/{post}/edit', 'EditController')->name('post.edit');
    Route::patch('/posts/{post}', 'UpdateController')->name('post.update');
    Route::delete('/posts/{post}', 'DeleteController')->name('post.delete');
});

Route::prefix('admin')->namespace('App\Http\Controllers\Admin\post')->middleware('admin')->name('admin.')->group(function() {
    Route::get('/post', 'IndexController')->name('post.index');
});

Route::get('/posts/update', [PostController::class,'update']);
Route::get('/posts/delete', [PostController::class,'delete']);
Route::get('/posts/first_or_create', [PostController::class,'firstOrCreate']);
Route::get('/posts/update_or_create', [PostController::class,'updateOrCreate']);

Route::get('/main', [MainController::class,'index'])->name('main.index');
Route::get('/about', [AboutController::class,'index'])->name('about.index');




Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
