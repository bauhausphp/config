<?php

namespace Bauhaus\Config;

use Bauhaus\Container\ItemNotFoundException;

class ParameterNotFoundException extends ItemNotFoundException
{
    protected function message(): string
    {
        return "Config parameter '{$this->label()}' not found";
    }
}
