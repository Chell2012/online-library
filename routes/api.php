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

//TODO: Переделать в Route Groups
//Route::middleware('auth:api')->resource('authors', AuthorController::class);
//Route::middleware('auth:api')->resource('books', BookController::class);
//Route::middleware('auth:api')->resource('categories', CategoryController::class);
//Route::middleware('auth:api')->resource('publishers', PublisherController::class);
//Route::middleware('auth:api')->resource('tags', TagController::class);

/*
 * Route for authors
 */
Route::middleware('auth:api')->get('/authors', [AuthorController::class, 'index']);
Route::middleware('auth:api')->post('/authors', [AuthorController::class, 'store']);
Route::middleware('auth:api')->get('/authors/{author:id}', [AuthorController::class, 'show']);
Route::middleware('auth:api')->patch('/authors/{author:id}', [AuthorController::class, 'update']);
Route::middleware('auth:api')->put('/authors/{author:id}', [AuthorController::class, 'update']);
Route::middleware('auth:api')->delete('/authors/{author:id}', [AuthorController::class, 'delete']);
/*
 * Route for books
 */
Route::middleware('auth:api')->get('/books', [BookController::class, 'index']);
Route::middleware('auth:api')->post('/books', [BookController::class, 'store']);
Route::middleware('auth:api')->get('/books/{book:id}', [BookController::class, 'show']);
Route::middleware('auth:api')->patch('/books/{book:id}', [BookController::class, 'update']);
Route::middleware('auth:api')->put('/books/{book:id}', [BookController::class, 'update']);
Route::middleware('auth:api')->delete('/books/{book:id}', [BookController::class, 'delete']);
/*
 * Route for categories
 */
Route::middleware('auth:api')->get('/categories', [CategoryController::class, 'index']);
Route::middleware('auth:api')->post('/categories', [CategoryController::class, 'store']);
Route::middleware('auth:api')->get('/categories/{category:id}', [CategoryController::class, 'show']);
Route::middleware('auth:api')->patch('/categories/{category:id}', [CategoryController::class, 'update']);
Route::middleware('auth:api')->put('/categories/{category:id}', [CategoryController::class, 'update']);
Route::middleware('auth:api')->delete('/categories/{category:id}', [CategoryController::class, 'delete']);
/*
 * Route for publishers
 */
Route::middleware('auth:api')->get('/publishers', [PublisherController::class, 'index']);
Route::middleware('auth:api')->post('/publishers', [PublisherController::class, 'store']);
Route::middleware('auth:api')->get('/publishers/{publisher:id}', [PublisherController::class, 'show']);
Route::middleware('auth:api')->patch('/publishers/{publisher:id}', [PublisherController::class, 'update']);
Route::middleware('auth:api')->put('/publishers/{publisher:id}', [PublisherController::class, 'update']);
Route::middleware('auth:api')->delete('/publishers/{publisher:id}', [PublisherController::class, 'delete']);
/*
 * Route for tags
 */
Route::middleware('auth:api')->get('/tags', [TagController::class, 'index']);
Route::middleware('auth:api')->post('/tags', [TagController::class, 'store']);
Route::middleware('auth:api')->get('/tags/{tag:title}', [TagController::class, 'show']);
Route::middleware('auth:api')->patch('/tags/{tag:title}', [TagController::class, 'update']);
Route::middleware('auth:api')->put('/tags/{tag:title}', [TagController::class, 'update']);
Route::middleware('auth:api')->patch('/tags/{tag:id}', [TagController::class, 'update']);
Route::middleware('auth:api')->put('/tags/{tag:id}', [TagController::class, 'update']);
Route::middleware('auth:api')->delete('/tags/{tag:id}', [TagController::class, 'delete']);


