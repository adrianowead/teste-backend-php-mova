<?php

use Slim\App;

return function (App $app) {
    $routeFnFiles = glob(__DIR__ . '/routes/routes-*.php');

    /** @psalm-suppress UnresolvableInclude */
    foreach ($routeFnFiles as $routeFnFile) {
        $routeFn = require $routeFnFile;
        $routeFn($app);
    }
};
