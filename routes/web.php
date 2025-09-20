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


Route::get('/reservations/create/{SLUG}', [ReservationController::class, 'create'])->name('reservations.create');
Route::post('/reservations',         [ReservationController::class, 'store'])->name('reservations.store');
Route::get('/reservations/success',  [ReservationController::class, 'success'])->name('reservations.success');



//Route::resource('products', ProductController::class);

Route::middleware('auth')->group(function () {
  Route::get('/home', function () {
    return redirect()->route('products.index');
  });

  Route::resource('reservations', ReservationAdminController::class);

    Route::get('/reservations/events/list',
        [ReservationAdminController::class, 'events']
    )->name('reservations.events.list');
  // Route::get('/reservations',        [ReservationAdminController::class, 'index'])->name('reservations.index');

  // 

  Route::get('/reservations/detail', [ReservationAdminController::class, 'show'])
     ->name('reservations.showEvent');
  // Route::patch('/reservations/{reservation}', [ReservationAdminController::class, 'update'])
  //   ->name('reservations.update');


  Route::resource('products', ProductController::class);
  Route::resource('users', UserController::class);
  Route::get('/contactMessages', [ContactMessageController::class, 'index'])
    ->name('contact_messages.index');
});
