<?php

namespace Intec\TransparenciaViagensServico\Test\Helper;

use DI\Container;
use Intec\IntecSlimBase\AppCreator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Slim\App;
use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Headers;
use Slim\Psr7\Request;
use Slim\Psr7\Uri;

trait AppSetup
{
    protected App $app;
    protected Container $container;
    protected LoggerInterface $logger;

    protected function initApp(): void
    {
        $this->app = $this->createAppInstance();

        /**
         * @psalm-suppress PropertyTypeCoercion
         */
        $this->container = $this->app->getContainer();
        /**
         * @psalm-suppress PossiblyNullReference
         */
        $this->logger = $this->container->get(LoggerInterface::class);
    }

    protected function runApp(
        string $method,
        string $path,
        array $parsedBody = [],
        array $headers = ['HTTP_ACCEPT' => 'application/json'],
        array $serverParams = [],
        array $cookies = [],
        array $uploadedFiles = [],
        string $bearerToken = null
    ): ResponseInterface {
        $encodedRequestConfig = json_encode([
            $method,
            $path,
            $parsedBody,
            $bearerToken
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        $this->logger->info($encodedRequestConfig);

        if ($bearerToken) {
            $headers['Authorization'] = sprintf('Bearer %s', $bearerToken);
        }

        $request = $this->createRequest(
            $method,
            $path,
            $parsedBody,
            $headers,
            $serverParams,
            $cookies,
            $uploadedFiles
        );

        $response = $this->app->handle($request);
        $this->logResponse($response);

        return $response;
    }

    protected function createRequest(
        string $method,
        string $path,
        array $parsedBody = [],
        array $headers = ['HTTP_ACCEPT' => 'application/json'],
        array $serverParams = [],
        array $cookies = [],
        array $uploadedFiles = []
    ): ServerRequestInterface {

        $pathAndQuery = explode('?', $path);

        $uri = new Uri('', '', 80, $pathAndQuery[0], $pathAndQuery[1] ?? '');
        $handle = fopen('php://temp', 'w+');
        $stream = (new StreamFactory())->createStreamFromResource($handle);

        $h = new Headers();
        foreach ($headers as $name => $value) {
            $h->addHeader($name, $value);
        }

        $request = new Request($method, $uri, $h, $cookies, $serverParams, $stream, $uploadedFiles);

        return $request->withParsedBody($parsedBody);
    }

    protected function decodeResponse(ResponseInterface $response, bool $asArray = true): array
    {
        return json_decode((string) $response->getBody(), $asArray);
    }

    private function logResponse(ResponseInterface $response): void
    {
        if (json_last_error()) {
            $this->logger->info((string) $response->getBody());
        } else {
            $data = $this->decodeResponse($response);
            $encodedResponseData = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            $this->logger->info($encodedResponseData);
        }
    }

    private function createAppInstance(): App
    {
        $appSettings = require __DIR__ . '/../../config/settings.php';

        $testSettingsFile = __DIR__ . '/../settings.local.php';
        $testLocalSettings = file_exists($testSettingsFile)
            ? require $testSettingsFile
            : [];

        $settings = array_merge($appSettings, $testLocalSettings);

        ini_set('date.timezone', $settings['app.timezone']);

        $appDependencies = require __DIR__ . '/../../config/dependencies.php';
        $testDependencies = require __DIR__ . '/../dependencies.php';
        $dependencies = array_merge($appDependencies, $testDependencies);

        $routes = require __DIR__ . '/../../config/routes.php';

        return AppCreator::createApp($settings, $dependencies, $routes);
    }
}
