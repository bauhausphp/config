<?php

namespace Bauhaus\Config\Exception;

class ConfigInvalidContentToLoadException extends \Exception
{
    public function __construct($filePath)
    {
        parent::__construct("The content file '$filePath' could not be loaded");
    }
}
