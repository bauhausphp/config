<?php

namespace Bauhaus;

use Bauhaus\Container;
use Bauhaus\Container\ItemNotFoundException;
use Bauhaus\Config\ParameterNotFoundException;

class Config extends Container
{
    public function __construct(array $configParameters)
    {
        foreach ($configParameters as $label => $parameter) {
            if ($this->isAssocArray($parameter)) {
                $configParameters[$label] = new self($parameter);
            }
        }

        parent::__construct($configParameters);
    }

    public function get($label)
    {
        try {
            return parent::get($label);
        } catch (ItemNotFoundException $e) {
            throw new ParameterNotFoundException($label);
        }
    }

    public function asArray(): array
    {
        $arrayToReturn = [];
        foreach ($this->items() as $label => $value) {
            if ($value instanceof Config) {
                $value = $value->asArray();
            }

            $arrayToReturn[$label] = $value;
        }

        return $arrayToReturn;
    }

    private function isAssocArray($parameter)
    {
        return is_array($parameter) and array_values($parameter) !== $parameter;
    }
}
