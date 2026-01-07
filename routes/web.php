<?php

use App\Http\Controllers\ForumController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::view('/login', 'login')->name('login');

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/forum', [ForumController::class, 'index'])->name('forum');
    Route::get('/moderator-panel', function () {
        return view('moderator-panel');
    })->name('moderator.panel');
    Route::get('/master-panel', function () {
        return view('master-panel');
    })->name('master.panel');
});


Route::redirect('/', '/login');
