<?php

use App\Events\WebsocketDemoEvent;
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

Route::get('/', function () {
    broadcast(new WebsocketDemoEvent('some data'));
    return view('welcome');
});
Route::get('/chats/{id}', [App\Http\Controllers\ChatsController::class, 'index'])->name('chats');

Route::get('/chat-page/{id}', [App\Http\Controllers\ChatsController::class, 'chat_page'])->name('chat_page');

Route::get('/messages_page/{id}', [App\Http\Controllers\ChatsController::class, 'messages_page'])->name('messages_page');

Route::post('/send_messages', [App\Http\Controllers\ChatsController::class, 'send_messages'])->name('send_messages');

Route::get('/send_user/{id}', [App\Http\Controllers\ChatsController::class, 'send_user'])->name('send_user');

Route::get('/delete_user', [App\Http\Controllers\ChatsController::class, 'delete_user'])->name('delete_user');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/admin-dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('admin');

Route::post('/room', [App\Http\Controllers\AdminController::class, 'room_page'])->name('room');

Route::get('/room-page', [App\Http\Controllers\AdminController::class, 'room'])->name('room_page');

Route::post('/fetch-room', [App\Http\Controllers\AdminController::class, 'fetchRoom'])->name('fetchRoom');

Route::post('/home-fetch-room', [App\Http\Controllers\HomeController::class, 'home_fetchRoom'])->name('home_fetchRoom');

Route::get('/delete-room', [App\Http\Controllers\HomeController::class, 'delete_room'])->name('delete_room');






