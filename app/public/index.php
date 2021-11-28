<?php

require __DIR__ . '/../vendor/autoload.php';

use Acme\Todo\HelloController;
use Acme\Todo\MySQLPooling;
use FrameworkX\App;

$app = new FrameworkX\App();

$connection = new MySQLPooling();

$app->get('/', new HelloController($connection));

$app->get('/users/{name}', function (Psr\Http\Message\ServerRequestInterface $request) {
    return new React\Http\Message\Response(
        200,
        [],
        "Hello " . $request->getAttribute('name') . "!\n"
    );
});

$app->run();