<?php

namespace Intec\TransparenciaViagensServico\Action;

use Intec\IntecSlimBase\Action\JsonAction;
use Psr\Http\Message\ResponseInterface;

class HealthCheck extends JsonAction
{
    public function __invoke(ResponseInterface $response): ResponseInterface
    {
        return $this->toJson($response);
    }
}
