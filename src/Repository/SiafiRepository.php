<?php

namespace Intec\TransparenciaViagensServico\Repository;

use Intec\IntecSlimBase\Exception\Domain\GenericDomainException;
use PDO;

class SiafiRepository implements RepositoryInterface
{
    public function __construct(private PDO $pdo)
    {
    }

    public function findSiafiByCode(string $siafiCode): array
    {
        $sth = $this->pdo->prepare('select * from siafi_codes where siafi_code = ?');
        $sth->execute([$siafiCode]);

        $siafi = $sth->fetch();

        if (!$siafi) {
            throw new GenericDomainException(
                ['siafi_code' => $siafiCode],
                "siafi code '{$siafiCode}' not found",
                100_000_101
            );
        }

        return $siafi;
    }
}
