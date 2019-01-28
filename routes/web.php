<?php

Route::group(['middleware'=>'auth'],function(){
    Route::post('/projects', 'ProjectsController@store');

    Route::get('/projects/create', 'ProjectsController@create');
    Route::get('/projects/{project}', 'ProjectsController@show');
    Route::get('/projects', 'ProjectsController@index');
});

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
