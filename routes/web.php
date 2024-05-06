<?php

use app\Core\Router;

Router::get('/auth/login', 'app\Controllers\AuthController@showLogin');
Router::post('/auth/login', 'app\Controllers\AuthController@login');

Router::get('/auth/register', 'app\Controllers\AuthController@showRegister');
Router::post('/auth/register', 'app\Controllers\AuthController@register');

Router::get('/auth/logout', 'app\Controllers\AuthController@logout');