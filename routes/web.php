<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes(['verify' => true]);

Route::get('/', 'HomeController@index')->middleware('verified')->name('home');
// search
Route::get('/search', 'HomeController@search')->name('search');

// facebook
Route::get('auth/facebook', 'Auth\LoginController@redirectToFacebook')->name('login.facebook');
Route::get('auth/facebook/callback', 'Auth\LoginController@handleFacebookCallback');

// Profile
Route::group(['prefix' => 'profile', 'middleware' => ['auth', 'verified']], function () {

    Route::get('edit', 'UserController@edit')->name('profile.edit');
    Route::post('update', 'UserController@update')->name('profile.update');
    Route::get('destroy', 'UserController@destroy')->name('profile.destroy');

});

// Send Message
Route::group(['prefix' => 'send_message'], function () {

    Route::get('/{key}', 'SendMessageController@index')->name('send_message.index');
    Route::post('/send/{id}', 'SendMessageController@send')->name('send_message.send');
    Route::get('/delete/{id}', 'SendMessageController@destroy')->name('send_message.delete')->middleware('auth');

    // get reply message
    Route::get('/get_reply/{message_id}', 'SendMessageController@get_reply')->middleware('auth');
    Route::post('/reply_message', 'SendMessageController@reply_message')->middleware('auth');
    Route::get('/show_reply/{message_id}', 'SendMessageController@show_reply')->middleware('auth');
    Route::get('/delete_reply/{reply_id}', 'SendMessageController@delete_reply')->middleware('auth');

});

// Send Message
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function () {

    Route::get('/', 'AdminController@index')->name('admin.index');

    Route::get('/users', 'AdminController@users')->name('admin.users');
    Route::get('/users/{id}', 'AdminController@deleteUser')->name('admin.deleteUser');
    Route::get('/users/rules/{id}', 'AdminController@rulesUser')->name('admin.rules');

    Route::get('/messages', 'AdminController@messages')->name('admin.messages');
    Route::get('/messages/{id}', 'AdminController@DeleteMessage')->name('admin.deleteMessage');

});