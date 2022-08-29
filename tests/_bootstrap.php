<?php
include __DIR__ . '/../vendor/autoload.php'; // composer autoload
$kernel = \AspectMock\Kernel::getInstance();

$kernel->init([
    'debug' => true,
    'appDir' => __DIR__ . '/../app/',
    'includePaths' => [__DIR__.'/../vendor/slim', __DIR__.'/../app'],
    'excludePaths' => [__DIR__], // tests dir should be excluded
    'cacheDir' => __DIR__ . '/aspectCache',
    'interceptFunctions' => true
]);

