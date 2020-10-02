<?php

declare(strict_types=1);

namespace PHPyh\Validator;

/**
 * @template R of Rule
 */
interface RuleHandler
{
    /**
     * @psalm-return class-string<R>
     */
    public static function rule(): string;

    /**
     * @param mixed $value
     * @psalm-param R $rule
     * @psalm-return \Generator<int, Error>
     */
    public function handle($value, Rule $rule, Validator $validator): \Generator;
}
