<?php

Route::group(['middleware' => 'auth'], function () {
  //TASK
  Route::patch('/projects/{project}/tasks/{task}', 'TasksController@update');
  Route::post('/projects/{project}/tasks', 'TasksController@store');
  Route::get('/projects/{project}/tasks', 'TasksController@index');
  
  //PROJECT
  Route::post('/projects', 'ProjectsController@store');
  Route::patch('/projects/{project}', 'ProjectsController@update');
  Route::get('/projects/create', 'ProjectsController@create');
  Route::get('/projects/{project}', 'ProjectsController@show');
  Route::get('/projects', 'ProjectsController@index');
});

Route::get('/', function () {
  return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
