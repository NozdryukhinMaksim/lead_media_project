<?php

use App\Http\Controllers\PostsController;
use App\Http\Controllers\TagsController;
use Illuminate\Support\Facades\Route;

Route::get( '/', [ PostsController::class, 'index' ] )->name( 'posts.index' );
Route::resource( 'posts', PostsController::class );
Route::resource( 'tags', TagsController::class );
Route::get('posts/{slug}', [PostController::class, 'show'])->name('posts.show');

Auth::routes();

Route::get( '/home', [ HomeController::class, 'index' ] )->name( 'home' );
