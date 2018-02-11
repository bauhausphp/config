<?php

namespace Bauhaus;

use PHPUnit\Framework\TestCase;

class VerifyIfItemExistsInContainerTest extends TestCase
{
    private $config;

    protected function setUp(): void
    {
        $this->config = new Config([
            'fefas' => [
                'pokemon' => 'charmander',
            ],
        ]);
    }

    /**
     * @test
     * @dataProvider existingPaths
     */
    public function returnTrueIfThereIsValueWithTheGivenPath(string $path)
    {
        $this->assertTrue($this->config->has($path));
    }

    public function existingPaths(): array
    {
        return [
            'Only root' => ['fefas'],
            'Root and subpath' => ['fefas.pokemon'],
        ];
    }

    /**
     * @test
     * @dataProvider nonExistingPaths
     */
    public function returnFalseIfThereIsNotValueWithTheGivenPath(string $path)
    {
        $this->assertFalse($this->config->has($path));
    }

    public function nonExistingPaths(): array
    {
        return [
            'Only root' => ['safef'],
            'Root and subpath' => ['fefas.instruments'],
        ];
    }
}
