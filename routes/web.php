<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

\Illuminate\Support\Facades\Auth::routes();

Route::get('login/{provider}', 'Auth\SocialAccountController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\SocialAccountController@handleProviderCallback');
