<?php

declare(strict_types=1);

namespace PHPyh\Validator\Rule;

use PHPUnit\Framework\TestCase;
use PHPyh\Validator\Error;
use PHPyh\Validator\Person;
use PHPyh\Validator\RuleHandlerRegistry\InMemoryRuleHandlerRegistry;
use PHPyh\Validator\Stub\Invalid;
use PHPyh\Validator\Stub\InvalidHandler;
use PHPyh\Validator\Stub\Valid;
use PHPyh\Validator\Validator;

/**
 * @internal
 * @covers \PHPyh\Validator\Rule\ObjectPropertiesHandler
 *
 * @small
 */
final class ObjectPropertiesHandlerTest extends TestCase
{
    /**
     * @param mixed $value
     * @dataProvider provideInvalidType
     */
    public function testInvalidType($value): void
    {
        $validator = $this->createValidator();
        $handler = new ObjectPropertiesHandler();
        $rule = new ObjectProperties([
            'name' => new Valid(),
        ]);

        $errors = $handler->handle($value, $rule, $validator);

        self::assertEquals(
            [
                Error::invalidType($value, 'object'),
            ],
            iterator_to_array($errors)
        );
    }

    /**
     * @psalm-return \Generator<int, array{mixed}>
     */
    public function provideInvalidType(): \Generator
    {
        yield ['a'];
        yield [1];
    }

    public function testInvalid(): void
    {
        $validator = $this->createValidator();
        $handler = new ObjectPropertiesHandler();
        $rule = new ObjectProperties([
            'name' => new Invalid(),
        ]);
        $person = new Person();

        $errors = $handler->handle($person, $rule, $validator);

        self::assertEquals(
            [
                InvalidHandler::error()->atProperty('name'),
            ],
            iterator_to_array($errors)
        );
    }

    public function testNullValid(): void
    {
        $validator = $this->createValidator();
        $handler = new ObjectPropertiesHandler();
        $rule = new ObjectProperties([
            'name' => new Invalid(),
        ]);

        $errors = $handler->handle(null, $rule, $validator);

        self::assertSame([], iterator_to_array($errors));
    }

    public function testPropertyDoesNotExist(): void
    {
        $validator = $this->createValidator();
        $handler = new ObjectPropertiesHandler();
        $rule = new ObjectProperties([
            'lastname' => new Invalid(),
        ]);
        $person = new Person();

        $errors = $handler->handle($person, $rule, $validator);

        self::assertEquals(
            [
                new Error(
                    '9fe39fea-ffbd-4653-b7cc-7e6a95be5928',
                    'Property {property} does not exist in class {class}.',
                    [
                        'property' => 'lastname',
                        'class' => 'PHPyh\Validator\Person',
                    ]
                ),
            ],
            iterator_to_array($errors)
        );
    }

    private function createValidator(): Validator
    {
        return new Validator(
            new InMemoryRuleHandlerRegistry([
                new InvalidHandler(),
            ])
        );
    }
}
