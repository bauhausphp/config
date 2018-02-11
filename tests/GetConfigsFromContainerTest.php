<?php

namespace Bauhaus;

use PHPUnit\Framework\TestCase;
use Psr\Container\NotFoundExceptionInterface as PsrNotFoundException;

class GetConfigsFromContainerTest extends TestCase
{
    /**
     * @test
     */
    public function returnValueWhenItIsASimpleValue()
    {
        $config = new Config([
            'key' => 'value',
        ]);

        $simpleValue = $config->get('key');

        $this->assertEquals('value', $simpleValue);
    }

    /**
     * @test
     */
    public function returnArrayWhenItIsANonAssocArray()
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
    public function returnSubconfigContainerWhenItIsAnAssocArray()
    {
        $config = new Config([
            'label' => [
                'pokemon' => 'charmander',
                'instrument' => 'bass',
            ],
        ]);
        $expectedSubconfig = new Config([
            'pokemon' => 'charmander',
            'instrument' => 'bass',
        ]);

        $subconfig = $config->get('label');

        $this->assertEquals($expectedSubconfig, $subconfig);
    }

    /**
     * @test
     */
    public function returnValueFromSubconfigContainerGivenCompletePath()
    {
        $config = new Config([
            'fefas' => [
                'pokemon' => 'charmander',
            ],
        ]);

        $value = $config->get('fefas.pokemon');

        $this->assertEquals('charmander', $value);
    }

    /**
     * @test
     * @dataProvider configsAndInvalidPaths
     */
    public function throwPsrNotFoundExceptionWhenTryToGetValueUsingAnInvalidPath(
        array $configs,
        string $invalidPath
    ) {
        $config = new Config($configs);

        $this->expectException(PsrNotFoundException::class);
        $this->expectExceptionMessage("Config '$invalidPath' not found");

        $config->get($invalidPath);
    }

    public function configsAndInvalidPaths(): array
    {
        return [
            'Empty config' => [
                [],
                'invalid.path',
            ],

            'Invalid root' => [
                ['pokemon' => 'charmander'],
                'instrument',
            ],

            'Valid root, but invalid subpath' => [
                ['invalid' => 'value'],
                'invalid.path',
            ],

            'Valid root, but invalid subpath' => [
                ['root' => ['subpath1' => ['subpath2' => 'value']]],
                'root.subpath1.invalid',
            ],
        ];
    }
}
