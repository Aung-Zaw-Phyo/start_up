<?php

use App\Livewire\Home;
use App\Livewire\PostDetail;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('home');
Route::get('/{postId}', PostDetail::class)->name('post-detail');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
