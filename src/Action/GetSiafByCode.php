<?php

namespace Intec\TransparenciaViagensServico\Action;

use Intec\IntecSlimBase\Action\JsonAction;
use Intec\TransparenciaViagensServico\Model\Siafi;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetSiafByCode extends JsonAction
{
    public function __construct(private Siafi $siafi)
    {
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        $params = $request->getQueryParams();

        $siafi = $this->siafi->getSiafiByCode($params['siafi_code']);

        return $this->toJson(response: $response, data: $siafi);
    }
}
