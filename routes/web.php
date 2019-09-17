<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::view('/', 'app');

Auth::routes(['verify' => true]);
Route::view('email/verified', 'auth/success_verified')->name('emailVerified');

Route::get('login/{provider}', 'Auth\SocialAccountController@redirectToProvider')->name('loginViaProvider');
Route::get('login/{provider}/callback', 'Auth\SocialAccountController@handleProviderCallback');

Route::get('settings', 'Settings@show')->name('settings');
Route::post('settings', 'Settings@save');

Route::get('history', 'History@show')->name('history');

Route::view('comments', 'comments')->name('comments');

Route::get('api/initData', 'MainApp@getInitData');
Route::post('api/saveCompletedTask', 'MainApp@saveCompletedTask');
Route::patch('api/task/{id}', 'MainApp@updateCompletedTask');
Route::delete('api/task/{id}', 'MainApp@deleteCompletedTask');

Route::view('legal/rules', 'legal.rules')->name('legal-rules');
