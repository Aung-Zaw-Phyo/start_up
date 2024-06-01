<?php

use App\Livewire\Home;
use App\Livewire\PostDetail;
use App\Livewire\Profile;
use Illuminate\Support\Facades\Route;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/', Home::class)->name('home');
    Route::get('/post/{postId}', PostDetail::class)->name('post-detail');
    Route::get('/profile', Profile::class);
});
