<?php

declare(strict_types=1);

namespace PHPyh\Validator\Rule;

use PHPUnit\Framework\TestCase;
use PHPyh\Validator\Error;
use PHPyh\Validator\RuleHandlerRegistry\InMemoryRuleHandlerRegistry;
use PHPyh\Validator\Validator;

/**
 * @internal
 * @covers \PHPyh\Validator\Rule\GreaterThanHandler
 *
 * @small
 */
final class GreaterThanHandlerTest extends TestCase
{
    /**
     * @param mixed $value
     * @dataProvider provideInvalidType
     */
    public function testInvalidType($value): void
    {
        $validator = $this->createEmptyValidator();
        $handler = new GreaterThanHandler();
        $rule = new GreaterThan(1);

        $errors = $handler->handle($value, $rule, $validator);

        self::assertEquals(
            [
                Error::invalidType($value, 'numeric', \DateTimeImmutable::class),
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
        yield [new \stdClass()];
    }

    /**
     * @psalm-param numeric|\DateTimeImmutable $ruleValue
     * @psalm-param null|numeric|\DateTimeImmutable $value
     * @dataProvider provideValid
     */
    public function testValid($ruleValue, $value): void
    {
        $validator = $this->createEmptyValidator();
        $handler = new GreaterThanHandler();
        $rule = new GreaterThan($ruleValue);

        $errors = $handler->handle($value, $rule, $validator);

        self::assertSame(0, iterator_count($errors));
    }

    /**
     * @psalm-return \Generator<int, array{numeric|\DateTimeImmutable, null|numeric|\DateTimeImmutable}>
     */
    public function provideValid(): \Generator
    {
        yield [0.9, null];
        yield [0.9, 1];
        yield ['0.9', '1'];
        yield [new \DateTimeImmutable('2020-01-01'), new \DateTimeImmutable('2020-01-02')];
    }

    /**
     * @psalm-param numeric|\DateTimeImmutable $ruleValue
     * @psalm-param null|numeric|\DateTimeImmutable $value
     * @dataProvider provideInvalid
     */
    public function testInvalid($ruleValue, $value): void
    {
        $validator = $this->createEmptyValidator();
        $handler = new GreaterThanHandler();
        $rule = new GreaterThan($ruleValue);

        $errors = $handler->handle($value, $rule, $validator);

        self::assertEquals(
            [
                new Error(
                    'a69899ca-65c0-40ae-b216-75af8802fbe6',
                    'Value {value} should be greater than {rule_value}',
                    ['value' => $value, 'rule_value' => $ruleValue]
                ),
            ],
            iterator_to_array($errors)
        );
    }

    /**
     * @psalm-return \Generator<int, array{numeric|\DateTimeImmutable, null|numeric|\DateTimeImmutable}>
     */
    public function provideInvalid(): \Generator
    {
        yield [1, 1];
        yield [1, 0.9];
        yield ['1', '1'];
        yield ['1', '0.9'];
        yield [new \DateTimeImmutable('2020-01-01'), new \DateTimeImmutable('2020-01-01')];
        yield [new \DateTimeImmutable('2020-01-02'), new \DateTimeImmutable('2020-01-01')];
    }

    private function createEmptyValidator(): Validator
    {
        return new Validator(new InMemoryRuleHandlerRegistry([]));
    }
}
