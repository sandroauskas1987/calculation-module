<?php
// Routes

/**
 * Swagger Documentation
 */
$app->get('/docs[/]', function ($request, $response, $args) {
    $openapi = \OpenApi\Generator::scan([__DIR__]);
    $data['swagger_json'] = str_replace('&quot;', '"', $openapi->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    return  $this->view->render($response, 'doc/openapi-specifacation.twig',  $data);
});