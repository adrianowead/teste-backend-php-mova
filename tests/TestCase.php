<?php

namespace Intec\TransparenciaViagensServico\Test;

use Intec\TransparenciaViagensServico\Test\Helper\AppSetup;
use PHPUnit\Framework\TestCase as FrameworkTestCase;

abstract class TestCase extends FrameworkTestCase
{
    use AppSetup;

    public function setUp(): void
    {
        $this->initApp();
        /** @psalm-suppress InternalMethod */
        $this->logger->notice(sprintf('#### Test: %s', $this->getName()));
    }

    public function tearDown(): void
    {
        switch ($this->getStatus()) {
            case 0:
                if ($this->getCount()) {
                    $this->logger->info(sprintf('Test status: ✔'));
                } else {
                    $this->logger->emergency(sprintf('Test status: ☢. Reason: Empty Test'));
                }
                break;
            default:
                $this->logger->error(sprintf('Test status: ✘. Reason: %s', $this->getStatusMessage()));
        }
    }
}
