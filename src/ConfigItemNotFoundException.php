<?php

namespace Bauhaus\Config;

use Bauhaus\Container\ContainerItemNotFoundException;

class ConfigItemNotFoundException extends ContainerItemNotFoundException
{
    protected function messageTemplate(): string
    {
        return "No config info found with label '%s'";
    }
}
