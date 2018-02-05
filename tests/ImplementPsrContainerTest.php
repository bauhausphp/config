<?php

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface as PsrContainer;
use Bauhaus\Config;

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
