<?php

use GuzzleHttp\Client;
use Intec\TransparenciaViagensServico\Service\SiafiService;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

use function DI\get;

return [
    PDO::class => function (ContainerInterface $c) {
        $host = $c->get('db.host');
        $dbname = $c->get('db.db_name');
        $charset = $c->get('db.charset');
        $dbUser = $c->get('db.db_user');
        $dbPass = $c->get('db.db_pass');

        $pdo = new PDO(
            "mysql:host=$host;dbname=$dbname;charset=$charset",
            $dbUser,
            $dbPass,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_PERSISTENT => false,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]
        );

        return $pdo;
    },
    LoggerInterface::class => function (ContainerInterface $c) {
        $logName = $c->get('app.name');
        $logger = new Logger($logName);
        $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
        $logger->pushHandler(new \Monolog\Handler\StreamHandler(
            $c->get('logger.path'),
            $c->get('logger.level')
        ));

        return $logger;
    },
    Logger::class => get(LoggerInterface::class),
    SiafiService::class => function (ContainerInterface $c) {

        $httpClient = new Client([
            'base_uri' => 'http://api.portaldatransparencia.gov.br',
            'headers' => [
                'chave-api-dados' => $c->get('transparencia.token'),
            ],
        ]);

        return new SiafiService($httpClient);
    },
];
