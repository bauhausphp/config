<?php

namespace Bauhaus\Config\Exception;

class ConfigFailedToReadStreamException extends \Exception
{
    public function __construct($filePath)
    {
        parent::__construct("Could not to read '$filePath'");
    }
}
