<?php

use App\Services\ValidatorService;

// DIC configuration
$container = $app->getContainer();

$container['view'] = function ($c) {
    $settings = $c->get('settings');
    $view = new Slim\Views\Twig($settings['renderer']['template_path'], $settings['renderer']['twig']);
    $view->addExtension(new Slim\Views\TwigExtension($c->get('router'), $c->get('request')->getUri()));
    return $view;
};
// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new \Slim\Views\Twig($settings['template_path']);
};

// debug
$container['debug'] = function ($c) {
    $debug = false;
    if (isset($c->get('settings')['debug']) ? $c->get('settings')['debug'] : false) {
        $debug = App\Lib\Debug::getInstance($c);
    }
    return $debug;
};

//connect db
$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();
$container['db'] = function ($c) use ($capsule) {
    return $capsule;
};

// endpoint ERROR
$container['errorHandler'] = function ($c) {
    return function ($request, $response, $exception) use ($c) {
        $debug = $c->get('debug');
        $data['status'] = false;
        $error = [
            'code' => $exception->getCode(),
            'message' => $exception->getMessage()
        ];

        if ($debug) {
            $error['file'] = $exception->getFile();
            $error['line'] = $exception->getLine();
            // $error['trace'] = explode("\n", $exception->getTraceAsString());
            $data['debug'] = $debug->get();
        }
        $data['errors'][] = $error;
        $error['code'] = (int)preg_replace("/[^0-9]/", '', $error['code']);
        $http_code = $error['code'];
        if (!in_array($http_code, \App\Lib\ErMessages::getUseHttpCode()))
            $http_code = 500;
        $response = $response
            ->withStatus($http_code)
            ->withHeader('Content-Type', 'application/json')
            ->withJson($data);
        return $response;
    };
};

// Not allow type request
$container['notAllowedHandler'] = function ($c) {
    return function ($request, $response, $methods) use ($c) {
        $debug = $c->get('debug');
        $data['errors'][] = array("code" => 405, "message" => 'Метод не поддерживается! Метод должен быть один из (' . implode(', ', $methods) . ')');
        $data['status'] = false;
        $response = $response
            ->withStatus(405)
            ->withHeader('Allow', implode(', ', $methods))
            ->withHeader('Content-type', 'application/json')
            ->withJson($data);
        if ($debug) $data['debug'] = $debug->get();
        return $response;
    };
};

// Not found URL 404
$container['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        $data = array('status' => false, 'errors' => [array('code' => '404', 'message' => 'Неизвестный запрос!')]);
        $response = $response->withJson($data, 404);
        $debug = $c->get('debug');
        if ($debug) $data['debug'] = $debug->get();
        return $response;
    };
};

$container['validator'] = function ($c) {
    return new ValidatorService();
};
