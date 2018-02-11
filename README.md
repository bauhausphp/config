[![Build Status](https://img.shields.io/travis/bauhausphp/config/master.svg?style=flat-square)](https://travis-ci.org/bauhausphp/config)
[![Coverage Status](https://img.shields.io/coveralls/bauhausphp/config/master.svg?style=flat-square)](https://coveralls.io/github/bauhausphp/config?branch=master)
[![Codacy Badge](https://img.shields.io/codacy/534139d09a5941ecbfcb9dd922e30111.svg?style=flat-square)](https://www.codacy.com/app/bauhausphp/config)

[![Latest Stable Version](https://poser.pugx.org/bauhaus/config/v/stable?format=flat-square)](https://packagist.org/packages/bauhaus/config)
[![Latest Unstable Version](https://poser.pugx.org/bauhaus/config/v/unstable?format=flat-square)](https://packagist.org/packages/bauhaus/config)
[![Total Downloads](https://poser.pugx.org/bauhaus/config/downloads?format=flat-square)](https://packagist.org/packages/bauhaus/config)
[![composer.lock](https://poser.pugx.org/bauhaus/config/composerlock?format=flat-square)](https://packagist.org/packages/bauhaus/config)

> **Warning!** This package won't worry about backward compatibily for `v0.*`.

# Bauhaus Config

Bauhaus Config aims to provide a simple way to load and validate configurations
via a container implementation of [PSR-11](http://www.php-fig.org/psr/psr-11/).

## TODOS

This package isn't still complete. Missing features are:

* Validate configuration schema (use JSON schema)
* Load from `yaml` (It will be done in a new repository bauhaus/config-yaml)

## Motivation

It's annoying when something inside your application breaks just because a
configuration entry was missing.

To prevent it, Bauhaus Config validates when the configurations are loaded
(being implemented).

## Usage

```php
<?php

use Psr\Container\NotFoundExceptionInterface as PsrNotFoundException;
use Psr\Container\ContainerInterface as PsrContainer;
use Bauhaus\Config;
use Bauhaus\Config\NotFoundException;

$config = new Config([
    'instrument' => 'bass',
    'pokemons' => ['charmander', 'pikachu'],
    'books' => [
        'study' => ['Clean Code', 'GOOS', 'Design Patterns'],
    ],
]);

$config instanceof PsrContainer; // true

$config->has('instrument'); // true
$config->has('pokemons'); // true
$config->has('books.study'); // true
$config->has('cars'); // false
$config->has('travels.asia'); // false

$config->get('instrument'); // 'bass'
$config->get('pokemons'); // ['charmander', 'pikachu']
$config->get('books'); // Config(['study' => ['Clean Code', 'GOOS', 'Design Patterns']])
$config->get('cars'); // throw NotFoundException implementing PsrNotFoundException
$config->get('travels.asia'); // throw NotFoundException implementing PsrNotFoundException

$config->get('books')->has('study'); // true
```

## Installation

Install it using [Composer](https://getcomposer.org/):

```shell
$ composer require bauhaus/config
```

## Coding Standard and Testing

This code has two levels of testing:

1. Coding standard (using PHPCS with PSR-2 standard):
   ```shell
   $ composer run test:cs
   ```

2. Unit tests (using PHPUnit):
   ```shell
   $ composer run test:unit
   ```

To run all at one:

```shell
$ composer run tests
```
