<?php

namespace Bauhaus;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface as PsrContainer;

class ImplementPsrContainerTest extends TestCase
{
    /**
     * @test
     */
    public function implementPsr11Container()
    {
        $config = new Config([]);

        $this->assertInstanceOf(PsrContainer::class, $config);
    }
}
