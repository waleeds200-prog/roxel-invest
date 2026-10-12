<?php

use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

Route::view('/our-dna', 'about')->name('about');
Route::permanentRedirect('/about', '/our-dna');

Route::view('/collection', 'services')->name('services');
Route::permanentRedirect('/services', '/collection');

Route::view('/bespoke', 'bespoke')->name('bespoke');

Route::get('/investor-relations', [ContactController::class, 'index'])->name('contact');
Route::post('/investor-relations', [ContactController::class, 'store'])->middleware('throttle:8,1440')->name('contact.store');
Route::post('/contact', [ContactController::class, 'store'])->middleware('throttle:8,1440');
Route::get('/contact', fn () => redirect()->route('contact', status: 301));
