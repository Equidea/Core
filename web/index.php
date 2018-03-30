<?php

use Equidea\Equidea;

use Equidea\Core\Http\{Request,Response};
use Equidea\Core\Http\Interfaces\{RequestInterface,ResponseInterface};
use Equidea\Core\Utility\Container;

// Start the session with a lifetime of two hours
session_start(['cookie_lifetime' => 7200]);

// Register the autoloading
spl_autoload_register(function ($class) {
    $class = substr($class, strlen('Equidea\\'));
    include __DIR__ .'/../src/' . str_replace('\\', '/', $class) . '.php';
});

// Create a new HTTP Request & Response
$request = Request::createFromGlobals();
$response = Response::createDefaultHtml();

// Create a new dependency injection container
$container = new Container();

// Register the Pages Controller
$container->register('PagesController',
function(RequestInterface $req, ResponseInterface $resp, Container $cont) {
    return new \Equidea\Bridge\Controller\PagesController($req, $resp, $cont);
});

// Register a new game instance
Equidea::register($request, $response, $container);

// Add default pages
Equidea::get('/', ['PagesController', 'index']);
Equidea::get('/json', ['PagesController', 'json']);
Equidea::notFound(['PagesController', 'notFound']);

// Get the parsed HTTP Response
Equidea::respond();
