<?php

namespace Intec\TransparenciaViagensServico\Test\Integration\Repository;

use Intec\TransparenciaViagensServico\Repository\SiafiRepository;
use Intec\TransparenciaViagensServico\Test\TestCase;
use PDO;

final class SiafiRepositoryITest extends TestCase
{
    public function testGetSiafiByCodeIntegration(): void
    {
        $siafiRepository = $this->createSiafiRepository();
        $siafiCode = '02000';
        $siafiDescription = 'descrição do orgão';
        $pdo = $this->container->get(PDO::class);

        $pdo->beginTransaction();

        $pdo->query("insert
            into siafi_codes
                (siafi_code, siafi_description)
            values('{$siafiCode}', '$siafiDescription');");

        $siafi = $siafiRepository->findSiafiByCode($siafiCode);
        $pdo->rollBack();

        $this->assertEquals($siafiCode, $siafi['siafi_code']);
        $this->assertEquals($siafiDescription, $siafi['siafi_description']);
    }

    private function createSiafiRepository(): SiafiRepository
    {
        return $this->container->get(SiafiRepository::class);
    }
}