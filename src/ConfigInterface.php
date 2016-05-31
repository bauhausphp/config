<?php

namespace Bauhaus;

interface ConfigInterface
{
    public function get(string $label);
    public function __get(string $label);
}
