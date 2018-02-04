<?php

namespace Bauhaus;

class ConfigTest extends \PHPUnit_Framework_TestCase
{
    private $config = null;

    protected function setUp()
    {
        $this->config = new Config(require __DIR__.'/../fixtures/config-sample.php');
    }

    /**
     * @test
     * @dataProvider simpleValuesAndThemLabels
     */
    public function retrieveValueOfASimpleParameterByItsLabel(
        string $expectedValue,
        string $label
    ) {
        $this->assertEquals($expectedValue, $this->config->$label);
    }

    public function simpleValuesAndThemLabels()
    {
        return [
            ['testing', 'environment'],
            [true, 'debug'],
            ['**************', 'googleMapsApiKey'],
            ['U-12345678', 'googleAnalyticsId'],
        ];
    }

    /**
     * @test
     * @dataProvider arraysAndThemLabels
     */
    public function retrieveArrayOfAListParameterByItsLabel(
        array $expectedValue,
        string $label
    ) {
        $this->assertEquals($expectedValue, $this->config->$label);
    }

    public function arraysAndThemLabels()
    {
        return [
            [
                [
                    'charmander',
                    'pikachu',
                    'butterfly',
                ],
                'pokemons'
            ],
            [
                [
                    'PHP',
                    'Python',
                    'Perl',
                    'C++',
                    'Java',
                    'Scala',
                ],
                'programmingLanguages'
            ],
        ];
    }

    /**
     * @test
     * @dataProvider assocArraysAndThemLabel
     */
    public function retrieveAnotherConfigContainerOfAnAssocArrayParameterByItsLabel(
        Config $expectedValue,
        string $label
    ) {
        $this->assertEquals($expectedValue, $this->config->$label);
    }

    public function assocArraysAndThemLabel()
    {
        return [
            [
                new Config([
                    'host' => 'localhost',
                    'dbname' => 'testing',
                    'user' => 'bauhaus',
                    'password' => 'secret',
                ]),
                'database',
            ],
            [
                new Config([
                    'baseUrl' => 'example.com/api/',
                    'token' => 'secret',
                ]),
                'exampleApi',
            ],
        ];
    }

    /**
     * @test
     */
    public function retrieveOriginalArrayUsedToCreateTheConfigContainer()
    {
        $expectedResult = [
            'environment' => 'testing',
            'debug' => true,
            'googleMapsApiKey' => '**************',
            'googleAnalyticsId' => 'U-12345678',

            'pokemons' => [
                'charmander',
                'pikachu',
                'butterfly',
            ],

            'programmingLanguages' => [
                'PHP',
                'Python',
                'Perl',
                'C++',
                'Java',
                'Scala',
            ],

            'database' => [
                'host' => 'localhost',
                'dbname' => 'testing',
                'user' => 'bauhaus',
                'password' => 'secret',
            ],

            'exampleApi' => [
                'baseUrl' => 'example.com/api/',
                'token' => 'secret',
            ],
        ];

        $this->assertEquals($expectedResult, $this->config->asArray());
    }

    /**
     * @test
     * @expectedException Bauhaus\Config\ParameterNotFoundException
     * @expectedExceptionMessage Config parameter 'invalid' not found
     */
    public function generateExceptionWhenRequestANonExistingLabel()
    {
        $this->config->invalid;
    }
}
