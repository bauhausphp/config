<?php

namespace Bauhaus\Config;

class ConfigItemNotFoundException extends \Exception
{
    public function __construct($label)
    {
        parent::__construct("No config info found with label '$label'");
    }
}
