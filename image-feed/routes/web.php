<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'PostsController@index')->name('index');
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::middleware(['auth'])->group(function () {
  Route::view('post/create', 'posts.create')->name('create_post');
  Route::post('posts/store', 'PostsController@store')->name('store_post');
  Route::get('posts/myposts', 'PostsController@show')->name('user_posts');
  Route::get('posts/pending', 'PostsController@approveIndex')->name('approve_post_list');
  Route::post('posts/approve/{post}', 'PostsController@approve')->name('approve_post');
  Route::get('get/images/{name}', function ($name) {
    Gate::authorize('approve-post');
    return response()->download(Storage::path("private\\$name"), null, [], null);
  })->name('get_image');
});
