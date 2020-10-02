<?php

declare(strict_types=1);

namespace PHPyh\Validator;

final class Validator
{
    private RuleHandlerRegistry $ruleHandlerRegistry;

    public function __construct(RuleHandlerRegistry $ruleHandlerRegistry)
    {
        $this->ruleHandlerRegistry = $ruleHandlerRegistry;
    }

    /**
     * @param mixed $value
     *
     * @return Error[]
     * @psalm-return list<Error>
     */
    public function validate($value, Rule $rule): array
    {
        $errors = $this
            ->ruleHandlerRegistry
            ->getRuleHandler(\get_class($rule))
            ->handle($value, $rule, $this)
        ;

        return iterator_to_array($errors, false);
    }
}
