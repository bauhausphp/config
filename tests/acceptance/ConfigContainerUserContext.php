<?php

namespace Bauhaus;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

require __DIR__ . '/../bootstrap.php';

class ConfigContainerUserContext implements Context, SnippetAcceptingContext
{
    private $config = null;
    private $outcome = null;

    /**
     * @Transform true
     */
    public function castTrue($true)
    {
        return true;
    }

    /**
     * @Transform :expectedArray
     */
    public function convertStringToArray($arrayString): array
    {
        $arr = [];

        foreach (explode(',', $arrayString) as $nameAndValue) {
            $nameAndValue = explode(':', $nameAndValue);
            $arr[$nameAndValue[0]] = $nameAndValue[1];
        }

        return $arr;
    }

    /**
     * @Given a config container loaded with the PHP file :phpFilePath
     */
    public function aConfigContainerLoadedWithThePhpFile($phpFilePath)
    {
        $this->config = Config::loadFromPHPFile(__DIR__ . '/../' . $phpFilePath);
    }

    /**
     * @When I request for the information labeled with :label
     */
    public function iRequestForTheInformationLabeledWith($label)
    {
        try {
            $this->outcome = $this->config->$label;
        } catch (\Exception $e) {
            $this->outcome = $e;
        }
    }

    /**
     * @Then I should receive the value :value
     */
    public function iShouldReceiveTheValue($value)
    {
        assertEquals($value, $this->outcome);
    }

    /**
     * @Then I should receive the another config container with the data :expectedArray
     */
    public function iShouldReceiveTheAnotherConfigContainerWithTheData($expectedArray)
    {
        assertEquals($this->outcome->all(), $expectedArray);

        foreach ($expectedArray as $label => $expectedValue) {
            assertEquals($expectedValue, $this->outcome->$label);
        }
    }

    /**
     * @Then I should receive the exception :exceptionClassName
     */
    public function iShouldReceiveTheException($exceptionClassName)
    {
        assertInstanceOf($exceptionClassName, $this->outcome);
    }
}
