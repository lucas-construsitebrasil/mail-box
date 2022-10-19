<?php

use App\Http\Controllers\V1\Messages\ReceiveMessages\ReceiveMessages;
use App\Http\Controllers\V1\Messages\SendMessages\SendMessages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/v1/inbox', [ReceiveMessages::class, 'get'])->name('inbox');
Route::get('/v1/send', [SendMessages::class, 'get'])->name('send.get');
Route::post('/v1/send', [SendMessages::class, 'post'])->name('send.post');