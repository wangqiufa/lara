<?php

$app['router']->get('/', function () {
    return '路由成功1';
});

$app['router']->get('welcome', 'App\Http\Controllers\WelcomeController@index');