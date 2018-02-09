<?php

namespace Bauhaus;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface as PsrContainer;
use Psr\Container\NotFoundExceptionInterface as PsrNotFoundException;

class GetConfigsFromContainerTest extends TestCase
{
    /**
     * @test
     */
    public function getValueWhenItemIsASimpleValue()
    {
        $config = new Config([
            'label' => 'item',
        ]);

        $simpleValue = $config->get('label');

        $this->assertEquals('item', $simpleValue);
    }

    /**
     * @test
     */
    public function getArrayWhenItemIsAnAssocArray()
    {
        $config = new Config([
            'label' => ['charmander', 'pikachu'],
        ]);

        $assocArray = $config->get('label');

        $this->assertEquals(['charmander', 'pikachu'], $assocArray);
    }

    /**
     * @test
     */
    public function getAnotherConfigContainerWhenItemIsAComplexArray()
    {
        $config = new Config([
            'label' => [
                'pokemon' => 'charmander',
                'instrument' => 'bass',
            ],
        ]);
        $expected = new Config([
            'pokemon' => 'charmander',
            'instrument' => 'bass',
        ]);

        $another = $config->get('label');

        $this->assertEquals($expected, $another);
    }

    /**
     * @test
     */
    public function getFromSubcontainerWhenGivenComposedLabel()
    {
        $config = new Config([
            'fefas' => [
                'pokemon' => 'charmander',
            ],
        ]);

        $itemValue = $config->get('fefas.pokemon');

        $this->assertEquals('charmander', $itemValue);
    }

    /**
     * @test
     * @dataProvider itemsAndInvalidLabels
     */
    public function throwPsrNotFoundExceptionWhenTryToGetUsingANonExistingLabel(
        array $items,
        string $invalidLabel
    ) {
        $config = new Config($items);

        $this->expectException(PsrNotFoundException::class);
        $this->expectExceptionMessage("Config item '$invalidLabel' not found");

        $config->get($invalidLabel);
    }

    public function itemsAndInvalidLabels(): array
    {
        return [
            'Empty config' => [
                [],
                'non.existing.label',
            ],

            'Non existing label' => [
                ['pokemon' => 'charmander'],
                'instrument',
            ],

            'Non existing composed label' => [
                ['non' => 'value'],
                'non.existing.label',
            ],
        ];
    }
}
