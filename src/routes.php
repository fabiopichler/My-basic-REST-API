<?php

$app->get('/posts', '\App\Controllers\PostsController:index');
$app->get('/posts/by-type/{type}', '\App\Controllers\PostsController:indexByType');

$app->get('/posts/{id}', '\App\Controllers\PostsController:show');
$app->get('/posts/by-slug/{slug}', '\App\Controllers\PostsController:showBySlug');
