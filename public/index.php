<?php
require __DIR__ . '/../vendor/autoload.php';

//Установить глобальные переменные пути
define('DS', DIRECTORY_SEPARATOR);
define('APP_PATH',  __DIR__.'/../app' . DS);
define('BASE_PATH', __DIR__ . '/..' . DS);
define('PUBLIC_PATH', __DIR__ . DS);
define('TZ_MOSCOW',  'Europe/Moscow');

// Instantiate the app
$dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH);
$dotenv->safeLoad();

$settings = require __DIR__ . '/../app/settings.php';

$app = new \Slim\App($settings);
// Set up dependencies
require __DIR__ . '/../app/dependencies.php';
// Register middleware
require __DIR__ . '/../app/Middleware/middleware.php';
// Register routes sait
require __DIR__ . '/../app/routes.php';
// Register routes api
require __DIR__ . '/../app/routes_api.php';

// Run app
$app->run();
