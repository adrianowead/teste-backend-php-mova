<?php

use Intec\TransparenciaViagensServico\Model\Siafi;
use Intec\TransparenciaViagensServico\Repository\SiafiRepository;
use Intec\TransparenciaViagensServico\Service\SiafiService;
use PHPUnit\Framework\TestCase;

final class SiafiUTest extends TestCase
{
    public function testGetSiafiCodesValidSiafi(): void
    {
        $expectedSiafi = [
            'id' => 1,
            'siafi_code' => '02000',
            'siafi_description' => 'Senado Federal - Unidades com vínculo direto',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $siafiService = $this->createMock(SiafiService::class);
        $siafiRepository = $this->createMock(SiafiRepository::class);

        $siafiRepository
            ->method('findSiafiByCode')
            ->willReturn($expectedSiafi);

        $siafiModel = new Siafi($siafiRepository, $siafiService);

        $actualSiafi = $siafiModel->getSiafiByCode($expectedSiafi['siafi_code']);

        $this->assertEquals($expectedSiafi, $actualSiafi);
    }
}
