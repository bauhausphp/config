<?php

namespace Bauhaus;

use InvalidArgumentException;
use Psr\Container\ContainerInterface as PsrContainer;
use Bauhaus\Config\NotFoundException;

class Config implements PsrContainer
{
    private const PATH_COMPONENT_DELIMITER = '.';

    private $values = [];

    public function __construct(array $values)
    {
        foreach ($values as $key => $value) {
            $this->add($key, $value);
        }
    }

    public function has($path)
    {
        try {
            $this->get($path);
        } catch (NotFoundException $ex) {
            return false;
        }

        return true;
    }

    public function get($path)
    {
        $components = explode(self::PATH_COMPONENT_DELIMITER, $path);

        $current = $this;
        foreach ($components as $component) {
            $canGetNext = $current instanceof Config && $current->hasKey($component);

            if (false === $canGetNext) {
                throw new NotFoundException($path);
            }

            $current = $current->values[$component];
        }

        return $current;
    }

    private function add(string $key, $value): void
    {
        if (is_object($value)) {
            throw new InvalidArgumentException("Config '$key' is an object");
        }

        $isAssocArray = is_array($value) && array_values($value) !== $value;

        $this->values[$key] = $isAssocArray ? new self($value) : $value;
    }

    private function hasKey($key): bool
    {
        return array_key_exists($key, $this->values);
    }
}
