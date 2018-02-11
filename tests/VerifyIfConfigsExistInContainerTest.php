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
     * @dataProvider existingLabels
     */
    public function returnTrueIfThereIsItemWithTheGivenLabel(string $label)
    {
        $this->assertTrue($this->config->has($label));
    }

    public function existingLabels(): array
    {
        return [
            'Simple label' => ['fefas'],
            'Composed label' => ['fefas.pokemon'],
        ];
    }

    /**
     * @test
     * @dataProvider nonExistingLabels
     */
    public function returnFalseIfThereIsNotItemWithTheGivenLabel(string $label)
    {
        $this->assertFalse($this->config->has($label));
    }

    public function nonExistingLabels(): array
    {
        return [
            'Simple label' => ['safef'],
            'Composed label' => ['fefas.intruments'],
        ];
    }
}
