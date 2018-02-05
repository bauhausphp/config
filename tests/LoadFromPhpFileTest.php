<?php

use PHPUnit\Framework\TestCase;
use Bauhaus\Config;
use Bauhaus\Config\InvalidSourceFileException;
use Bauhaus\Config\CouldNotOpenFileException;

class CreateFromPhpFileTest extends TestCase
{
    /**
     * @test
     */
    public function loadConfigGivenAPathToAPhpFileWhichReturnsAnArray()
    {
        $expected = new Config([
            'pokemons' => [
                'charmander',
                'pikachu',
            ],
        ]);

        $config = Config::fromPhp(__DIR__.'/config-sample.php');

        $this->assertEquals($expected, $config);
    }

    /**
     * @test
     */
    public function throwInvalidSourceFileExceptionIfGivenPhpFileDoesNotReturnAnArray()
    {
        $filePath = __DIR__.'/invalid.php';
        $this->expectException(InvalidSourceFileException::class);
        $this->expectExceptionMessage("Invalid source file '$filePath'");

        Config::fromPhp($filePath);
    }

    /**
     * @test
     */
    public function throwCouldNotOpenFileExceptionIfGivenFilePathIsNotReachable()
    {
        $filePath = __DIR__.'/non-existente.php';
        $this->expectException(CouldNotOpenFileException::class);
        $this->expectExceptionMessage("Could not open file '$filePath'");

        Config::fromPhp($filePath);
    }
}
