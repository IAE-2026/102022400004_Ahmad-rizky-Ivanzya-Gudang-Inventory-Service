<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

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
