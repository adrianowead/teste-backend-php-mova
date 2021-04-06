<?php

$settings = require __DIR__ . '/config/settings.php';

return [
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/data/database/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/data/database/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_database' => 'development',
        'development' => [
            'adapter' => 'mysql',
            'host' => $settings['db.host'],
            'name' => $settings['db.db_name'],
            'user' => $settings['db.db_user'],
            'pass' => $settings['db.db_pass'],
            'port' => $settings['db.db_port'],
            'charset' => $settings['db.charset'],
        ],
        'staging' => [
            'adapter' => 'mysql',
            'host' => $settings['db.host'],
            'name' => $settings['db.db_name'],
            'user' => $settings['db.db_user'],
            'pass' => $settings['db.db_pass'],
            'port' => $settings['db.db_port'],
            'charset' => $settings['db.charset'],
        ]
    ],
    'version_order' => 'creation'
];
