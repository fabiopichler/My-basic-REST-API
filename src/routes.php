<?php

$app->get('/pages', '\App\Controllers\PagesController:index');
$app->get('/pages/{id}', '\App\Controllers\PagesController:show');

$app->get('/posts', '\App\Controllers\PagesController:index');
$app->get('/posts/{id}', '\App\Controllers\PagesController:show');
