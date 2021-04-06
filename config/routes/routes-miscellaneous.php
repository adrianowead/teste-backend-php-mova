<?php

use Intec\TransparenciaViagensServico\Action\HealthCheck;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    $app->group('', function (RouteCollectorProxy $group) {
        $group->get('/healthz', HealthCheck::class);
    });
};
