<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', 'TodoController@index');
$router->get('/a', 'TodoController@act');
$router->post('/todo/create', 'TodoController@create');
$router->post('/todo/update/{id}', 'TodoController@updateStatus');
$router->delete('/todo/delete/{id}', 'TodoController@destroy');

$router->get('/js/{filename}', function ($filename) {
    $path = base_path('public/js/' . $filename);

    if (file_exists($path)) {
        $mimeType = mime_content_type($path);
        return response()->file($path, ['Content-Type' => $mimeType]);
    } else {
        abort(404);
    }
});
$router->get('/css/{filename}', function ($filename) {
    $path = base_path('public/css/' . $filename);

    if (file_exists($path)) {
        $mimeType = mime_content_type($path);
        return response()->file($path, ['Content-Type' => $mimeType]);
    } else {
        abort(404);
    }
});

$router->post('/ruta-protegida', [
    'middleware' => 'age',
    'uses' => 'TodoController@testM'
]);