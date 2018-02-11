<?php

namespace Bauhaus\Config;

use RuntimeException;

class SourceFileNotReachableException extends RuntimeException
{
    public function __construct($filePath)
    {
        parent::__construct("Could not open file '$filePath'");
    }
}
