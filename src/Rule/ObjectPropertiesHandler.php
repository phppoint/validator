<?php

declare(strict_types=1);

namespace PHPyh\Validator\Rule;

use PHPyh\Validator\Error;
use PHPyh\Validator\Rule;
use PHPyh\Validator\RuleHandler;
use PHPyh\Validator\Validator;

/**
 * @implements RuleHandler<ObjectProperties>
 */
final class ObjectPropertiesHandler implements RuleHandler
{
    private const PROPERTY_DOES_NOT_EXIST = '9fe39fea-ffbd-4653-b7cc-7e6a95be5928';

    public static function rule(): string
    {
        return ObjectProperties::class;
    }

    /**
     * @param ObjectProperties $rule
     */
    public function handle($value, Rule $rule, Validator $validator): \Generator
    {
        if ($value === null) {
            return;
        }

        if (!\is_object($value)) {
            yield Error::invalidType($value, 'object');

            return;
        }

        foreach ($rule->propertyRules as $property => $propertyRule) {
            if (!property_exists($value, $property)) {
                yield new Error(
                    self::PROPERTY_DOES_NOT_EXIST,
                    'Property {property} does not exist in class {class}.',
                    [
                        'property' => $property,
                        'class' => \get_class($value),
                    ]
                );

                continue;
            }

            foreach ($validator->validate($value->{$property}, $propertyRule) as $propertyError) {
                yield $propertyError->atProperty($property);
            }
        }
    }
}
