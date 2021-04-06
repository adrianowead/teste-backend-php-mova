<?php

namespace Intec\TransparenciaViagensServico\Service;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Intec\IntecSlimBase\Exception\Domain\GenericDomainException;

class SiafiService
{
    private const SIAFI_CODES = '/api-de-dados/orgaos-siafi';

    public function __construct(private Client $httpClient)
    {
    }

    public function getSiafiCodes(int $pageNumber): ?array
    {
        $queryParams = [
            'pagina' => $pageNumber,
        ];

        try {
            return $this->get(self::SIAFI_CODES, $queryParams);
        } catch (Exception $e) {
            throw new GenericDomainException($queryParams, $e->getMessage(), 100_000_100, $e);
        }
    }

    private function get(string $path, array $queryParams): ?array
    {
        try {
            $response = $this->httpClient->request('GET', $path, [
                'query' => $queryParams,
            ]);

            return $response->getStatusCode() != 204
                ? json_decode((string) $response->getBody(), true)
                : null;
        } catch (BadResponseException $e) {
            $message = (string) ($e->getResponse())->getBody();
            if (!$message) {
                $message = $e->getMessage();
            }

            throw new Exception($message, 0, $e);
        }
    }
}
