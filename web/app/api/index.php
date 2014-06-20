<?php

require_once __DIR__ . '/../../php/vendor/autoload.php';

$app = new Silex\Application();
$app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__,
    )
);

$app->get('/', function() use($app) {
    return "hallo!";
});

$app->run();