<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Form;

/*
  |--------------------------------------------------------------------------
  | API Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register API routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | is assigned the "api" middleware group. Enjoy building your API!
  |
  | Routes inside this file will be prefixed with /api/
  | (to edit prefix see RouteServiceProvider)
  |
  |
 */

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['middleware' => 'auth:api'], function() {
    // Form routes
    Route::get('forms', 'FormController@index');
    Route::get('forms/{form}', 'FormController@show');
    Route::post('forms', 'FormController@store');
    Route::put('forms/{form}', 'FormController@update');
    Route::delete('forms/{form}', 'FormController@delete');
});


// User routes
Route::post('register', 'Auth\RegisterController@register');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout');

