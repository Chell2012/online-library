<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\VerificationController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function (){
    return view('welcome');
})->name('welcome');

/**
 * Auth routes
 */
Auth::routes();

/**
 *
 * Verification
 */
Route::get('/email/verify', [VerificationController::class,'show'])->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify')->middleware(['signed']);
Route::post('/email/resend', [VerificationController::class, 'resend'])->name('verification.resend');

Route::middleware(['auth','verified'])->group(function (){
    Route::get('/home', [BookController::class, 'index'])->name('home');
    /*
     * Resource routes
     */
    Route::resource('author', AuthorController::class);
    Route::resource('book', BookController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('publisher', PublisherController::class);
    Route::resource('tag', TagController::class);

    Route::post('/author/approve', [AuthorController::class,'approve'])->name('author.approve');
    Route::post('/book/approve', [BookController::class,'approve'])->name('book.approve');
    Route::post('/category/approve', [CategoryController::class,'approve'])->name('category.approve');
    Route::post('/publisher/approve', [PublisherController::class,'approve'])->name('publisher.approve');
    Route::post('/tag/approve', [TagController::class,'approve'])->name('tag.approve');

    Route::post('/book/loadfrom', [BookController::class,'loadfrom'])->name('book.loadfrom');
});

