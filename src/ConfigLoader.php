<?php

namespace Bauhaus;

use Bauhaus\Config\SourceFileInvalidException;
use Bauhaus\Config\SourceFileNotReachableException;

class ConfigLoader
{
    public static function fromPhp(string $file): Config
    {
        if (false === is_readable($file)) {
            throw new SourceFileNotReachableException($file);
        }

        $values = require $file;

        if (false === is_array($values)) {
            throw new SourceFileInvalidException($file);
        }

        return new Config($values);
    }
}
