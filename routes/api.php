<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RestorePasswordController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\VerifyEmailController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user(); 
});
Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');
Route::post('/email/verify/resend', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return ['message'=> 'Verification link sent!'];
})->middleware(['auth:api', 'throttle:6,1'])->name('verification.send');
Route::post('/forgot-password',[RestorePasswordController::class,'sendToken'])
    ->middleware('guest')
    ->name('password.email');
Route::post('/reset-password',[RestorePasswordController::class,'changePassword'])
    ->middleware('guest')
    ->name('password.reset');
Route::middleware('guest')->group(function (){
    /*
     * Route for books
     */
    Route::get('/books', [BookController::class, 'index']);
    Route::get('/books/{book:id}', [BookController::class, 'show']);
    Route::get('/filter', [BookController::class, 'filter']);
    /*
     * Route for authors
     */
    Route::get('/authors', [AuthorController::class, 'index']);
    Route::get('/authors/{author:id}', [AuthorController::class, 'show']);
    /*
     * Route for categories
     */
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/{category:id}', [CategoryController::class, 'show']);
    /*
     * Route for publishers
     */
    Route::get('/publishers', [PublisherController::class, 'index']);
    Route::get('/publishers/{publisher:id}', [PublisherController::class, 'show']);
    /*
     * Route for tags
     */
    Route::get('/tags', [TagController::class, 'index']);
    Route::get('/tags/{tag:title}', [TagController::class, 'show']);
    Route::get('/tags/{tag:id}', [TagController::class, 'show']);
    /*
     * User routes
     */
    Route::post('/register', RegisterController::class);
    
});
Route::middleware('auth:api','verified')->group(function (){
    /*
     * Route for books
     */
    Route::get('/books-all', [BookController::class, 'viewNotApproved']);
    Route::post('/books', [BookController::class, 'store']);
    Route::patch('/books/{book:id}', [BookController::class, 'update']);
    Route::put('/books/{book:id}', [BookController::class, 'update']);
    Route::delete('/books/{book:id}', [BookController::class, 'destroy']);
    Route::post('/books/approve', [BookController::class, 'approve']);
    /*
     * Route for authors
     */
    Route::get('/authors-all', [AuthorController::class, 'viewNotApproved']);
    Route::post('/authors', [AuthorController::class, 'store']);
    Route::patch('/authors/{author:id}', [AuthorController::class, 'update']);
    Route::put('/authors/{author:id}', [AuthorController::class, 'update']);
    Route::delete('/authors/{author:id}', [AuthorController::class, 'destroy']);
    Route::post('/authors/approve', [AuthorController::class, 'approve']);
    /*
     * Route for categories
     */
    Route::get('/categories-all', [CategoryController::class, 'viewNotApproved']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::patch('/categories/{category:id}', [CategoryController::class, 'update']);
    Route::put('/categories/{category:id}', [CategoryController::class, 'update']);
    Route::delete('/categories/{category:id}', [CategoryController::class, 'destroy']);
    Route::post('/categories/approve', [CategoryController::class, 'approve']);
    /*
     * Route for publishers
     */
    Route::get('/publishers-all', [PublisherController::class, 'viewNotApproved']);
    Route::post('/publishers', [PublisherController::class, 'store']);
    Route::patch('/publishers/{publisher:id}', [PublisherController::class, 'update']);
    Route::put('/publishers/{publisher:id}', [PublisherController::class, 'update']);
    Route::delete('/publishers/{publisher:id}', [PublisherController::class, 'destroy']);
    Route::post('/publishers/approve', [PublisherController::class, 'approve']);
    /*
     * Route for tags
     */
    Route::get('/tags-all', [TagController::class, 'viewNotApproved']);
    Route::post('/tags', [TagController::class, 'store']);
    Route::patch('/tags/{tag:title}', [TagController::class, 'update']);
    Route::put('/tags/{tag:title}', [TagController::class, 'update']);
    Route::patch('/tags/{tag:id}', [TagController::class, 'update']);
    Route::put('/tags/{tag:id}', [TagController::class, 'update']);
    Route::delete('/tags/{tag:id}', [TagController::class, 'destroy']);
    Route::post('/tags/approve', [TagController::class, 'approve']);
    /*
     * User routes
     */
    Route::post('/logout', LogoutController::class);
});

