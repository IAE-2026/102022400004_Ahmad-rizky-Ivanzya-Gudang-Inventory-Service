<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::redirect('/swagger-ui', '/api/documentation');
Route::redirect('/swagger-ui/', '/api/documentation');

Route::get('/docs/api-docs.json', function () {
    return response()->file(storage_path('api-docs/api-docs.json'), [
        'Content-Type' => 'application/json'
    ]);
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
