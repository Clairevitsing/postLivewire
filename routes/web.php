<?php

use App\Livewire\PostList;
use App\Livewire\PostForm;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('posts', PostList::class )->name('posts');
Route::get('posts/create', PostForm::class )->name('posts.create');
