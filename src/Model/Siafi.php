<?php

namespace Intec\TransparenciaViagensServico\Model;

use Intec\TransparenciaViagensServico\Repository\SiafiRepository;
use Intec\TransparenciaViagensServico\Service\SiafiService;

class Siafi
{
    public function __construct(private SiafiRepository $siafiRepository, private SiafiService $siafiService)
    {
    }

    public function getSiafiByCode(string $siafiCode): array
    {
        return $this->siafiRepository->findSiafiByCode($siafiCode);
    }
}
