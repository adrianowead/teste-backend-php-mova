<?php

use Intec\IntecSlimBase\AppCreator;

require __DIR__ . '/../vendor/autoload.php';

$settings = require __DIR__ . '/../config/settings.php';
\ini_set('date.timezone', $settings['app.timezone']);

$dependencies = require __DIR__ . '/../config/dependencies.php';
$routes = require __DIR__ . '/../config/routes.php';

$app = AppCreator::createApp(
    $settings,
    $dependencies,
    $routes
);

$app->run();
