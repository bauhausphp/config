<?php

namespace Bauhaus\Config;

class ConfigTest extends \PHPUnit_Framework_TestCase
{
    private $config = null;

    protected function setUp()
    {
        $this->config = new Config(require __DIR__ . '/../fixtures/config-sample.php');
    }

    /**
     * @test
     * @dataProvider simpleValueAndItsLabel
     */
    public function retrievingSimpleValueWhenRequireOneLevelDeepData($expected, $label)
    {
        $this->assertEquals($expected, $this->config->$label);
    }

    public function simpleValueAndItsLabel()
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
     * @dataProvider arrayAndItsLabel
     */
    public function retrievingArrayWhenRequireDataThatContainsAList($expected, $label)
    {
        $this->assertEquals($expected, $this->config->$label);
    }

    public function arrayAndItsLabel()
    {
        return [
            [['val1', 'val2'], 'someList'],
        ];
    }

    /**
     * @test
     * @dataProvider configContainerAndItsLabel
     */
    public function retrievingAnotherConfigContainerWhenRequireAssocArrayData($expected, $label)
    {
        $this->assertEquals($expected, $this->config->$label);
    }

    public function configContainerAndItsLabel()
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
                    'token' => '*********',
                ]),
                'someApi',
            ]
        ];
    }

    /**
     * @test
     * @expectedException Bauhaus\Config\ConfigItemNotFoundException
     * @expectedExceptionMessage No config info found with label 'invalid'
     */
    public function generateExceptionWhenRequestANonExistingLabel()
    {
        $this->config->invalid;
    }
}
