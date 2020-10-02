<?php

declare(strict_types=1);

namespace PHPyh\Validator\Stub;

use PHPyh\Validator\Error;
use PHPyh\Validator\Rule;
use PHPyh\Validator\RuleHandler;
use PHPyh\Validator\Validator;

/**
 * @implements RuleHandler<Invalid>
 */
final class InvalidHandler implements RuleHandler
{
    private static ?Error $error = null;

    public static function rule(): string
    {
        return Invalid::class;
    }

    public static function error(): Error
    {
        return self::$error ??= new Error('8519d6db-7842-4d9a-804e-b0b4f7c0ca61', 'message template', ['variable' => 'value']);
    }

    public function handle($value, Rule $rule, Validator $validator): \Generator
    {
        yield self::error();
    }
}
