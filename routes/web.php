<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContactMessageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;

Route::get('/', [App\Http\Controllers\LandingController::class, 'index'])->name('homePage');

Route::get('/detail/{SLUG}', [App\Http\Controllers\LandingController::class, 'detail'])->name('product-detail');

Auth::routes();

Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');

Route::get('/register', function () {
    abort(404);
});

Route::get('/home', function(){ return redirect()->route('products.index'); });

//Route::resource('products', ProductController::class);

Route::middleware('auth')->group(function () {
    Route::resource('products', ProductController::class);
  Route::resource('users', UserController::class);
    Route::get('/contactMessages', [ContactMessageController::class, 'index'])
        ->name('contact_messages.index');
});