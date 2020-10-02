<?php

declare(strict_types=1);

namespace PHPyh\Validator;

/**
 * @psalm-immutable
 */
final class Person
{
    public string $name;

    public int $age;

    public function __construct(string $name = 'Valentin', int $age = 26)
    {
        $this->name = $name;
        $this->age = $age;
    }
}
