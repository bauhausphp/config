<?php

namespace Bauhaus\Config;

interface ConfigInterface
{
    public function __get(string $label);
}
