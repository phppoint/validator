<?php

declare(strict_types=1);

namespace PHPyh\Validator\Stub;

use PHPyh\Validator\Rule;
use PHPyh\Validator\RuleHandler;
use PHPyh\Validator\Validator;

/**
 * @implements RuleHandler<Valid>
 */
final class ValidHandler implements RuleHandler
{
    public static function rule(): string
    {
        return Valid::class;
    }

    public function handle($value, Rule $rule, Validator $validator): \Generator
    {
        yield from [];
    }
}
