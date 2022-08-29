<?php
$app->group('/services', function () use ($app) {
    $app->get('/fast', App\Controllers\v1\Services::class . ':Fast');
    $app->get('/slow', App\Controllers\v1\Services::class . ':Slow');
    $app->get('', App\Controllers\v1\Services::class . ':AllDelivery');
});