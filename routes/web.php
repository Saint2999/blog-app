<?php

use app\Core\Router;

Router::get('/auth/login', 'app\Controllers\AuthController@showLogin');
Router::post('/auth/login', 'app\Controllers\AuthController@login');

Router::get('/auth/register', 'app\Controllers\AuthController@showRegister');
Router::post('/auth/register', 'app\Controllers\AuthController@register');

Router::get('/auth/logout', 'app\Controllers\AuthController@logout');


Router::get('/articles', 'app\Controllers\ArticlesController@index');

Router::get('/articles/store', 'app\Controllers\ArticlesController@create');

Router::post('/articles/store', 'app\Controllers\ArticlesController@store');

Router::get('/articles/show', 'app\Controllers\ArticlesController@show');

Router::get('/articles/update', 'app\Controllers\ArticlesController@edit');

Router::patch('/articles/update', 'app\Controllers\ArticlesController@update');

Router::delete('/articles/destroy', 'app\Controllers\ArticlesController@destroy');