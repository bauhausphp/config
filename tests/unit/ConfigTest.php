<?php

namespace Bauhaus;

class ConfigTest extends \PHPUnit_Framework_TestCase
{
    private $config = null;

    protected function setUp()
    {
        $this->config = Config::loadFromPHPFile(__DIR__ . '/../config-sample.php');
    }

    /**
     * @test
     * @testdox Loading configuration from PHP file
     * @dataProvider labelAndValuesOfOneLevelDataOfSampleConfigInfo
     */
    public function loadingConfigurationFromPHPFile($label, $value)
    {
        $this->assertEquals($value, $this->config->$label);
    }

    public function labelAndValuesOfOneLevelDataOfSampleConfigInfo()
    {
        return [
            ['environment', 'testing'],
            ['debug', true],
            ['googleMapsApiKey', '**************'],
            ['googleAnalyticsId', 'U-12345678'],
        ];
    }

    /**
     * @test
     * @dataProvider dataOfSecondLevelDataOfSampleConfigInfo
     */
    public function accessingNthLevelInfoAsAnotherConfigContainer($expected, $firstLevelLabel)
    {
        $this->assertEquals($expected, $this->config->$firstLevelLabel->all());

        foreach ($expected as $label => $expectedLabelValue) {
            $this->assertEquals(
                $expectedLabelValue,
                $this->config->$firstLevelLabel->$label
            );
        }
    }

    public function dataOfSecondLevelDataOfSampleConfigInfo()
    {
        return [
            [
                [
                    'host' => 'localhost',
                    'dbname' => 'testing',
                    'user' => 'bauhaus',
                    'password' => 'secret',
                ],
                'database',
            ],
            [
                [
                    'baseUrl' => 'example.com/api/',
                    'token' => '*********',
                ],
                'someApi',
            ]
        ];
    }

    /**
     * @test
     * @dataProvider invalidLabels
     * @expectedException Bauhaus\Config\Exception\ConfigLabelNotFoundException
     */
    public function generateExceptionWhenRequestANonExistingLabel($invalidLabel)
    {
        $this->config->$invalidLabel;
    }

    public function invalidLabels()
    {
        return [
            ['invalidLabel1'],
            ['invalidLabel2'],
        ];
    }

    /**
     * @test
     * @expectedException Bauhaus\Config\Exception\ConfigFailedToReadStreamException
     */
    public function generateExceptionWhenInformANotReadablePathToLoad()
    {
        $this->config = Config::loadFromPHPFile('invalid.php');
    }

    /**
     * @test
     * @testdox Generate exception when inform a PHP file with invalid content to laod
     * @expectedException Bauhaus\Config\Exception\ConfigInvalidContentToLoadException
     */
    public function generateExceptionWhenInformAPHPFileWithInvalidContentToLoad()
    {
        $this->config = Config::loadFromPHPFile(__DIR__ . '/../config-invalid-sample.php');
    }
}
