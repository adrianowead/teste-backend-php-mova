<?php

use Monolog\Logger;

use function DI\env;

return [
    // app
    'app.cache_enabled' => (bool) getenv('ROUTE_CACHE'),
    'app.name' => getenv('APP_NAME'),
    'app.display_error_details' => false,
    'app.timezone' => 'America/Sao_Paulo',
    // logger
    'logger.name' => 'logger_name',
    'logger.path' => __DIR__ . '/../var/logs/app.log',
    'logger.level' => getenv('DEBUG_MODE') ? Logger::DEBUG : Logger::ERROR,
    // db
    'db.host' => getenv('DB_HOST'),
    'db.db_name' => getenv('DB_NAME'),
    'db.db_user' => getenv('DB_USER'),
    'db.db_pass' => getenv('DB_PASS'),
    'db.db_port' => getenv('DB_PORT'),
    'db.charset' => 'utf8mb4',
    'transparencia.token' => 'meu-token-secreto',
];
