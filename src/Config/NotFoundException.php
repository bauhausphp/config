<?php

namespace Bauhaus\Config;

use RuntimeException;
use Psr\Container\NotFoundExceptionInterface as PsrNotFoundException;

class NotFoundException extends RuntimeException implements PsrNotFoundException
{
    public function __construct(string $key)
    {
        parent::__construct("Config '$key' not found");
    }
}
