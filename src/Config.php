<?php

namespace Bauhaus;

use Bauhaus\Container;
use Bauhaus\Container\ItemNotFoundException;
use Bauhaus\Config\ParameterNotFoundException;

class Config extends Container
{
    public function __construct(array $configData)
    {
        $arr = [];
        foreach ($configData as $label => $value) {
            if (is_array($value) and array_values($value) !== $value) {
                $value = new self($value);
            }

            $arr[$label] = $value;
        }

        parent::__construct($arr);
    }

    public function get($label)
    {
        try {
            return parent::get($label);
        } catch (ItemNotFoundException $e) {
            throw new ParameterNotFoundException($label);
        }
    }
}
