<?php

namespace Bauhaus\Config;

class ConfigTest extends \PHPUnit_Framework_TestCase
{
    private $config = null;

    protected function setUp()
    {
        $this->config = new Config(require __DIR__ . '/../config-sample.php');
    }

    /**
     * @test
     * @dataProvider valuesAndLabelOfSimpleData
     */
    public function retrievingValueWhenRequireSimpleData($expected, $label)
    {
        $this->assertEquals($expected, $this->config->$label);
    }

    public function valuesAndLabelOfSimpleData()
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
     * @dataProvider sequencialArraysAndLabelOfListData
     */
    public function retrievingSequecialArrayWhenRequireListData($expected, $label)
    {
        $this->assertEquals($expected, $this->config->$label);
    }

    public function sequencialArraysAndLabelOfListData()
    {
        return [
            [['val1', 'val2'], 'someList'],
        ];
    }

    /**
     * @test
     * @dataProvider configContainerAndLabelOfAssocArrayData
     */
    public function retrievingAnotherConfigContainerWhenRequireAssocArrayData($expected, $label)
    {
        $this->assertEquals($expected, $this->config->$label);
    }

    public function configContainerAndLabelOfAssocArrayData()
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
     * @expectedException Bauhaus\Config\Exception\ConfigItemNotFound
     * @expectedExceptionMessage No config info found with label 'invalid'
     */
    public function generateExceptionWhenRequestANonExistingLabel()
    {
        $this->config->invalid;
    }
}
