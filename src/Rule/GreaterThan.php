<?php

declare(strict_types=1);

namespace PHPyh\Validator\Rule;

use PHPyh\Validator\Rule;

/**
 * @psalm-immutable
 */
final class GreaterThan implements Rule
{
    /**
     * @psalm-var numeric|\DateTimeImmutable
     */
    public $value;

    /**
     * @psalm-param numeric|\DateTimeImmutable $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }
}
