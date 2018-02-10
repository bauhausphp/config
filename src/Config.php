<?php

namespace Bauhaus;

use InvalidArgumentException;
use Psr\Container\ContainerInterface as PsrContainer;
use Bauhaus\Config\NotFoundException;
use Bauhaus\Config\InvalidSourceFileException;
use Bauhaus\Config\CouldNotOpenFileException;

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
        return $this->resolvePath($path);
    }

    private function add(string $key, $value): void
    {
        if (is_object($value)) {
            throw new InvalidArgumentException("Config '$key' is an object");
        }

        $isAssocArray = is_array($value) && array_values($value) !== $value;

        if ($isAssocArray) {
            $value = new self($value);
        }

        $this->values[$key] = $value;
    }

    private function resolvePath(string $path)
    {
        list($root, $subpath) = $this->splitPathRoot($path);

        if (false === $this->hasKey($root)) {
            throw new NotFoundException($path);
        }

        $value = $this->values[$root];

        if (empty($subpath)) {
            return $value;
        }

        if (!$value instanceof Config) {
            throw new NotFoundException($path);
        }

        return $value->get($subpath);
    }

    private function splitPathRoot(string $path): array
    {
        $components = explode(self::PATH_COMPONENT_DELIMITER, $path);

        $root = array_shift($components);
        $subpath = implode(self::PATH_COMPONENT_DELIMITER, $components);

        return [$root, $subpath];
    }

    private function hasKey($key): bool
    {
        return array_key_exists($key, $this->values);
    }

    public static function fromPhp(string $file): self
    {
        if (false === is_readable($file)) {
            throw new CouldNotOpenFileException($file);
        }

        $values = require $file;

        if (false === is_array($values)) {
            throw new InvalidSourceFileException($file);
        }

        return new self($values);
    }
}
