<?php

use app\Core\Router;

Router::get('/auth/login', 'app\Controllers\AuthController@showLogin');
Router::post('/auth/login', 'app\Controllers\AuthController@login');

Router::get('/auth/register', 'app\Controllers\AuthController@showRegister');
Router::post('/auth/register', 'app\Controllers\AuthController@register');

Router::get('/auth/logout', 'app\Controllers\AuthController@logout');


Router::get('/', 'app\Controllers\ArticlesController@index');

Router::get('/articles', 'app\Controllers\ArticlesController@index');

Router::get('/articles/store', 'app\Controllers\ArticlesController@create');

Router::post('/articles/store', 'app\Controllers\ArticlesController@store');

Router::get('/articles/show', 'app\Controllers\ArticlesController@show');

Router::get('/articles/update', 'app\Controllers\ArticlesController@edit');

Router::post('/articles/update', 'app\Controllers\ArticlesController@update');

Router::post('/articles/destroy', 'app\Controllers\ArticlesController@destroy');


Router::get('/comments/store', 'app\Controllers\CommentsController@create');

Router::post('/comments/store', 'app\Controllers\CommentsController@store');

Router::get('/comments/update', 'app\Controllers\CommentsController@edit');

Router::post('/comments/update', 'app\Controllers\CommentsController@update');

Router::post('/comments/destroy', 'app\Controllers\CommentsController@destroy');