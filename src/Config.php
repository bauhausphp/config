<?php

namespace Bauhaus\Config;

use Bauhaus\Container\Container;
use Bauhaus\Container\ContainerItemNotFoundException;

class Config extends Container
{
    public function __construct(array $configData)
    {
        $arr = [];
        foreach ($configData as $label => $value) {
            if (is_array($value) and array_values($value) !== $value) {
                $value = new Config($value);
            }

            $arr[$label] = $value;
        }

        parent::__construct($arr);
    }

    public function __get(string $label)
    {
        try {
            return parent::__get($label);
        } catch (ContainerItemNotFoundException $e) {
            throw new ConfigItemNotFoundException($label);
        }
    }
}
