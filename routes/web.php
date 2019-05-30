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
    return view('welcome');
});

Route::group(['namespace' => 'Home'], function() {
    Route::get("/", "HomeController@index");
    Route::any("/index", "HomeController@index");
    Route::any("/lobby", "HomeController@lobby");
    Route::any("/dashboard", "HomeController@dashboard");
    Route::any("/registerdetail", "HomeController@registerDetail");
    Route::any("/logindetail", "HomeController@loginDetail");
    Route::any("/recorddetail", "HomeController@recordDetail");
    Route::any("/register", "HomeController@register");
    Route::any("/login", "HomeController@login");
    Route::any("/logout", "HomeController@logout");
    
    Route::any("/creategame", "HomeController@createGame");
    Route::any("/readgame", "HomeController@readGame");
    Route::any("/startgame", "HomeController@startGame");
    Route::any("/endgame", "HomeController@endGame");
    
    Route::any("/readcard", "HomeController@readCard");
    Route::any("/playcard", "HomeController@playCard");
    
    Route::any("/readplayer", "HomeController@readPlayer");
    
    Route::any("/createrecord", "HomeController@createRecord");
    Route::any("/readrecord", "HomeController@readRecord");
    
    Route::any("/createchannel", "HomeController@createChannel");
    Route::any("/deletechannel", "HomeController@deleteChannel");
});