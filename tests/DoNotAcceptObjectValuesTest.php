<?php

namespace Bauhaus;

use StdClass;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class DoNotAcceptObjectValuesTest extends TestCase
{
    /**
     * @test
     */
    public function throwInvalidArgumentExceptionIfGivenValueIsAnObject()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Config 'key' is an object");

        new Config([
            'key' => new StdClass(),
        ]);
    }
}
