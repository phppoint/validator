<?php

declare(strict_types=1);

namespace PHPyh\Validator\Rule;

use PHPyh\Validator\Error;
use PHPyh\Validator\Rule;
use PHPyh\Validator\RuleHandler;
use PHPyh\Validator\Validator;

/**
 * @implements RuleHandler<GreaterThan>
 */
final class GreaterThanHandler implements RuleHandler
{
    private const GREATER_THAN = 'a69899ca-65c0-40ae-b216-75af8802fbe6';

    public static function rule(): string
    {
        return GreaterThan::class;
    }

    /**
     * @param GreaterThan $rule
     */
    public function handle($value, Rule $rule, Validator $validator): \Generator
    {
        if ($value === null) {
            return;
        }

        if (!is_numeric($value) && !$value instanceof \DateTimeImmutable) {
            yield Error::invalidType($value, 'numeric', \DateTimeImmutable::class);

            return;
        }

        if ($value > $rule->value) {
            return;
        }

        yield new Error(
            self::GREATER_THAN,
            'Value {value} should be greater than {rule_value}',
            [
                'value' => $value,
                'rule_value' => $rule->value,
            ]
        );
    }
}
