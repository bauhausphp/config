<?php

namespace Bauhaus\Config;

use RuntimeException;

class SourceFileInvalidException extends RuntimeException
{
    public function __construct($filePath)
    {
        parent::__construct("Invalid source file '$filePath'");
    }
}
