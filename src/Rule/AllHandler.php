<?php

declare(strict_types=1);

namespace PHPyh\Validator\Rule;

use PHPyh\Validator\Rule;
use PHPyh\Validator\RuleHandler;
use PHPyh\Validator\Validator;

/**
 * @implements RuleHandler<All>
 */
final class AllHandler implements RuleHandler
{
    public static function rule(): string
    {
        return All::class;
    }

    /**
     * @param All $rule
     */
    public function handle($value, Rule $rule, Validator $validator): \Generator
    {
        foreach ($rule->rules as $oneRule) {
            yield from $validator->validate($value, $oneRule);
        }
    }
}
