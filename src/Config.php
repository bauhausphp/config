<?php

namespace Bauhaus\Config;

use Bauhaus\Container\ReadableContainer;
use Bauhaus\Container\Exception\ContainerItemNotFound;
use Bauhaus\Config\Exception\ConfigItemNotFound;

class Config extends ReadableContainer implements ConfigInterface
{
    public function __construct(array $configInfo)
    {
        foreach ($configInfo as $label => $value) {
            if (is_array($value) and array_values($value) !== $value) {
                $value = new Config($value);
            }

            $this->_register($label, $value);
        }
    }

    public function __get(string $label)
    {
        try {
            return parent::__get($label);
        } catch (ContainerItemNotFound $e) {
            throw new ConfigItemNotFound($label);
        }
    }
}
