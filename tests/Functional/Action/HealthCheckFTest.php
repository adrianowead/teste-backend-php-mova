<?php

namespace Intec\TransparenciaViagensServico\Test\Functional\Action;

use Intec\TransparenciaViagensServico\Test\TestCase;

final class HealthCheckFTest extends TestCase
{
    public function testHealthCheckWillReturn200StatusCode(): void
    {
        $resp = $this->runApp('GET', '/healthz');

        $this->assertEquals(200, $resp->getStatusCode());
    }
}
