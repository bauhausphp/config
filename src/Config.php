<?php

namespace Bauhaus;

use Bauhaus\Container\ReadableContainer;
use Bauhaus\Container\Exception\ContainerItemNotFoundException;
use Bauhaus\Config\Exception\ConfigLabelNotFoundException;
use Bauhaus\Config\Exception\ConfigFailedToReadStreamException;
use Bauhaus\Config\Exception\ConfigInvalidContentToLoadException;

class Config extends ReadableContainer implements ConfigInterface
{
    public function __construct(array $configInfo)
    {
        foreach ($configInfo as $label => $value) {
            if (is_array($value)) {
                $value = new Config($value);
            }

            $this->_register($label, $value);
        }
    }

    public function get(string $label)
    {
        try {
            return parent::get($label);
        } catch (ContainerItemNotFoundException $e) {
            throw new ConfigLabelNotFoundException($label);
        }
    }

    public static function loadFromPHPFile(string $phpFilePath)
    {
        if (is_readable($phpFilePath) === false) {
            throw new ConfigFailedToReadStreamException($phpFilePath);
        }

        $configInfo = require $phpFilePath;

        if (is_array($configInfo) === false) {
            throw new ConfigInvalidContentToLoadException($phpFilePath);
        }

        return new Config($configInfo);
    }
}
