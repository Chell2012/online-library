<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\TagController;

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




Route::middleware('auth:api')->group(function (){
    /*
     * Route for books
     */
    Route::get('/books', [BookController::class, 'index']);
    Route::post('/books', [BookController::class, 'store']);
    Route::get('/books/{book:id}', [BookController::class, 'show']);
    Route::patch('/books/{book:id}', [BookController::class, 'update']);
    Route::put('/books/{book:id}', [BookController::class, 'update']);
    Route::delete('/books/{book:id}', [BookController::class, 'destroy']);
    /*
     * Route for authors
     */
    Route::get('/authors', [AuthorController::class, 'index']);
    Route::post('/authors', [AuthorController::class, 'store']);
    Route::get('/authors/{author:id}', [AuthorController::class, 'show']);
    Route::patch('/authors/{author:id}', [AuthorController::class, 'update']);
    Route::put('/authors/{author:id}', [AuthorController::class, 'update']);
    Route::delete('/authors/{author:id}', [AuthorController::class, 'destroy']);
    /*
     * Route for categories
     */
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::get('/categories/{category:id}', [CategoryController::class, 'show']);
    Route::patch('/categories/{category:id}', [CategoryController::class, 'update']);
    Route::put('/categories/{category:id}', [CategoryController::class, 'update']);
    Route::delete('/categories/{category:id}', [CategoryController::class, 'destroy']);
    /*
     * Route for publishers
     */
    Route::get('/publishers', [PublisherController::class, 'index']);
    Route::post('/publishers', [PublisherController::class, 'store']);
    Route::get('/publishers/{publisher:id}', [PublisherController::class, 'show']);
    Route::patch('/publishers/{publisher:id}', [PublisherController::class, 'update']);
    Route::put('/publishers/{publisher:id}', [PublisherController::class, 'update']);
    Route::delete('/publishers/{publisher:id}', [PublisherController::class, 'destroy']);
    /*
     * Route for tags
     */
    Route::get('/tags', [TagController::class, 'index']);
    Route::post('/tags', [TagController::class, 'store']);
    Route::get('/tags/{tag:title}', [TagController::class, 'show']);
    Route::patch('/tags/{tag:title}', [TagController::class, 'update']);
    Route::put('/tags/{tag:title}', [TagController::class, 'update']);
    Route::patch('/tags/{tag:id}', [TagController::class, 'update']);
    Route::put('/tags/{tag:id}', [TagController::class, 'update']);
    Route::delete('/tags/{tag:id}', [TagController::class, 'destroy']);
});
