<?php

use Intec\TransparenciaViagensServico\Action\GetSiafByCode;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    $app->group('/transparencia', function (RouteCollectorProxy $group) {
        $group->get('/siafi', GetSiafByCode::class);
    });
};
