<?php

namespace Intec\TransparenciaViagensServico\Test\Functional\Action;

use Intec\IntecSlimBase\Exception\Domain\GenericDomainException;
use Intec\TransparenciaViagensServico\Repository\SiafiRepository;
use Intec\TransparenciaViagensServico\Test\TestCase;

final class GetSiafiByCodeFTest extends TestCase
{
    public function testGetSiafiByCodeWillReturn200(): void
    {
        $siafi = [
            'id' => 1,
            'siafi_code' => '02000',
            'siafi_description' => 'Senado Federal - Unidades com vínculo direto',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $siafiRepositoryMock = $this->createMock(SiafiRepository::class);
        $siafiRepositoryMock
            ->expects($this->once())
            ->method('findSiafiByCode')
            ->with($siafi['siafi_code'])
            ->willReturn($siafi);

        $this->container->set(SiafiRepository::class, $siafiRepositoryMock);

        $resp = $this->runApp('GET', '/transparencia/siafi?siafi_code=' . $siafi['siafi_code']);

        $this->assertEquals(200, $resp->getStatusCode());
        $siafiResult = $this->decodeResponse($resp)['data'];

        $this->assertEquals($siafi, $siafiResult);
    }

    public function testGetSiafiByCodeWillThrowNotFoundException(): void
    {
        $siafiCode = '02000';
        $errorMessage = 'some error message';

        $siafiRepositoryMock = $this->createMock(SiafiRepository::class);
        $siafiRepositoryMock
            ->expects($this->once())
            ->method('findSiafiByCode')
            ->willThrowException(new GenericDomainException([], $errorMessage));

        $this->container->set(SiafiRepository::class, $siafiRepositoryMock);

        $resp = $this->runApp('GET', '/transparencia/siafi?siafi_code=' . $siafiCode);

        $this->assertEquals(400, $resp->getStatusCode());
        $siafiMessage = $this->decodeResponse($resp)['message'];

        $this->assertEquals($errorMessage, $siafiMessage);
    }
}
