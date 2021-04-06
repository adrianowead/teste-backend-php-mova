<?php

use Faker\Factory as FakerFactory;
use Faker\Provider\pt_BR\Company;
use Faker\Provider\pt_BR\Person;
use Monolog\Logger;
use Psr\Container\ContainerInterface;

return [
    FakerFactory::class => function () {
        $faker = FakerFactory::create();
        $faker->addProvider(new Person($faker));
        $faker->addProvider(new Company($faker));

        return $faker;
    },
    'testLogger' => function (ContainerInterface $c) {
        $logger = new Logger($c->get('app.name'));
        $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
        $logger->pushHandler(new \Monolog\Handler\StreamHandler($c->get('logger.path'), (int) getenv('LOG_LEVEL')));

        return $logger;
    },
];
