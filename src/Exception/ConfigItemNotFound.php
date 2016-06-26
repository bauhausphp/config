<?php

namespace Bauhaus\Config\Exception;

class ConfigItemNotFound extends \Exception
{
    public function __construct($label)
    {
        parent::__construct("No config info found with label '$label'");
    }
}
