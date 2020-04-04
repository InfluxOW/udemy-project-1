<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'HomeController@home')->name('home');
Route::get('/contact', 'HomeController@contact')->name('contact');
Route::get('/contact-secret', 'HomeController@contactSecret')->name('contact.secret')->middleware('can:contact.secret');
Route::resource('posts', 'PostController');
Route::resource('users', 'UserController')->only('show', 'edit', 'update');
Auth::routes();
Route::get('/posts/tag/{tag}', 'PostTagController@index')->name('posts.tags.index');
Route::resource('posts.comments', 'PostCommentController')->only('store');
Route::resource('users.comments', 'UserCommentController')->only('store');
Route::get('mailable', function () {
    $comment = App\Comment::find(1);
    return new App\Mail\CommentPostedMarkdown($comment);
});
