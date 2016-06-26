<?php

namespace Bauhaus\Config;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

require __DIR__ . '/../bootstrap.php';

class ConfigContainerClientContext implements Context, SnippetAcceptingContext
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
     * @Transform :expectedList
     */
    public function convertStringToList($string): array
    {
        return explode(',', $string);
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
     * @Given a config container created using the PHP file :filePath
     */
    public function aConfigContainerCreatedUsingThePhpFile($filePath)
    {
        $this->config = new Config(require __DIR__ . "/$filePath");
    }

    /**
     * @When I require the item labeled with :label
     */
    public function iRequireTheItemLabeledWith($label)
    {
        try {
            $this->outcome = $this->config->$label;
        } catch (\Exception $e) {
            $this->outcome = $e;
        }
    }

    /**
     * @Then I should receive the value :expectedValue
     */
    public function iShouldReceiveTheValue($expectedValue)
    {
        assertEquals($expectedValue, $this->outcome);
    }

    /**
     * @Then I should receive the the list :expectedList
     */
    public function iShouldReceiveTheTheList($expectedList)
    {
        assertEquals($expectedList, $this->outcome);
    }

    /**
     * @Then I should receive another config container with the data :expectedArray
     */
    public function iShouldReceiveAnotherConfigContainerWithTheData($expectedArray)
    {
        assertEquals($this->outcome->all(), $expectedArray);
    }

    /**
     * @Then the exception :exceptionClass is throwed with the message:
     */
    public function iShouldReceiveTheException(
        $exceptionClass,
        PyStringNode $message
    ) {
        assertInstanceOf($exceptionClass, $this->outcome);
        assertEquals($message->getRaw(), $this->outcome->getMessage());
    }
}
