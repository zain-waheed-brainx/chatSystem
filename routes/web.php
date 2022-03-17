<?php

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
    return redirect('/login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/chat-list', 'ChatController@chatList')->name('chat_list');
Route::get('/user-list', 'ChatController@userList')->name('user_list');
Route::get('/message-list/{id}', 'ChatController@messageList')->name('message_list');
Route::post('/send-message', 'ChatController@sendMessage')->name('send_message');
Route::post('/create-group', 'ChatController@createGroup')->name('create_group');
