<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContactMessageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReservationAdminController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;

Route::get('/', [App\Http\Controllers\LandingController::class, 'index'])->name('homePage');

Route::get('/detail/{SLUG}', [App\Http\Controllers\LandingController::class, 'detail'])->name('product-detail');

Auth::routes();

Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');

Route::get('/register', function () {
  abort(404);
});

Route::get('/contact/appointment/{SLUG}', [ContactController::class, 'appointment'])->name('appointment-visit');


Route::get('/appointment/create/{SLUG}', [ReservationController::class, 'create'])->name('reservations.createUser');
Route::post('/appointment/user/store',         [ReservationController::class, 'store'])->name('reservations.user.store');
Route::get('/appointment/success',  [ReservationController::class, 'success'])->name('reservations.success');



//Route::resource('products', ProductController::class);

Route::middleware('auth')->group(function () {
  Route::get('/home', function () {
    return redirect()->route('products.index');
  });

  Route::resource('reservations', ReservationAdminController::class)->except(['create']);;
    Route::get('/reservations/events/list',
        [ReservationAdminController::class, 'events']
    )->name('reservations.events.list');


  Route::get('/reservations/detail', [ReservationAdminController::class, 'show'])
     ->name('reservations.showEvent');

  Route::resource('products', ProductController::class);
  Route::resource('users', UserController::class);
  Route::get('/contactMessages', [ContactMessageController::class, 'index'])
    ->name('contact_messages.index');
});
