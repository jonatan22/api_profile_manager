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

Route::get('/profile/{profileId}/get-profile', 'Api\ProfileController@getProfile')->name('user.profile.getProfile');
Route::post('/profile/{profileId}/upload-image', 'Api\ProfileController@uploadImage')->name('user.profile.uploadImage');
Route::post('/profile/create-profile', 'Api\ProfileController@insertProfile')->name('user.profile.insertProfile');
Route::put('/profile/{profileId}/update-profile', 'Api\ProfileController@updateProfile')->name('user.profile.updateProfile');
Route::delete('/profile/{profileId}/delete-profile', 'Api\ProfileController@deleteProfile')->name('user.profile.deleteProfile');
