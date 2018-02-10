<?php

namespace Bauhaus\Config;

use RuntimeException;

class InvalidSourceFileException extends RuntimeException
{
    public function __construct($filePath)
    {
        parent::__construct("Invalid source file '$filePath'");
    }
}
