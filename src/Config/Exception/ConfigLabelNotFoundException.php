<?php

namespace Bauhaus\Config\Exception;

class ConfigLabelNotFoundException extends \Exception
{
    public function __construct($label)
    {
        parent::__construct("No config found with label '$label'");
    }
}
