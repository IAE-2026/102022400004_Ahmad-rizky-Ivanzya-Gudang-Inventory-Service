<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::redirect('/api/documentation', '/docs');
Route::redirect('/swagger-ui', '/docs');
Route::redirect('/swagger-ui/', '/docs');

// Manual route for GraphQL Playground (workaround for package auto-discovery issues in newer Laravel)
Route::get('/graphql-playground', function () {
    return view('vendor.graphql-playground.index', [
        'graphqlEndpoint' => '/graphql',
    ]);
});

Route::get('/playground', function () {
    return view('vendor.graphql-playground.index', [
        'graphqlEndpoint' => '/graphql',
    ]);
});
