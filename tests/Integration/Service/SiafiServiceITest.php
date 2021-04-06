<?php

namespace Intec\TransparenciaViagensServico\Test\Integration\Service;

use Intec\TransparenciaViagensServico\Service\SiafiService;
use Intec\TransparenciaViagensServico\Test\TestCase;

final class SiafiServiceITest extends TestCase
{
    public function testGetSiafiCodesIntegration(): void
    {
        $jobTravelsService = $this->createSiafiService();

        $codes = $jobTravelsService->getSiafiCodes(pageNumber: 1);

        // print_r(array_map(function ($code) {
        //     return sprintf('%s: %s', $code['codigo'], $code['descricao']);
        // }, $codes));

        $this->assertIsArray($codes);
    }

    private function createSiafiService(): SiafiService
    {
        return $this->container->get(SiafiService::class);
    }
}
