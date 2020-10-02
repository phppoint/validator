<?php

declare(strict_types=1);

namespace PHPyh\Validator;

use PHPUnit\Framework\TestCase;
use PHPyh\Validator\RuleHandlerRegistry\InMemoryRuleHandlerRegistry;
use PHPyh\Validator\Stub\Invalid;
use PHPyh\Validator\Stub\InvalidHandler;
use PHPyh\Validator\Stub\Valid;
use PHPyh\Validator\Stub\ValidHandler;

/**
 * @internal
 * @covers \PHPyh\Validator\Validator
 *
 * @small
 */
final class ValidatorTest extends TestCase
{
    public function testValidateInvalid(): void
    {
        $validator = new Validator(
            new InMemoryRuleHandlerRegistry([
                new InvalidHandler(),
            ])
        );

        $errors = $validator->validate(1, new Invalid());

        self::assertSame([InvalidHandler::error()], $errors);
    }

    public function testValidateValid(): void
    {
        $validator = new Validator(
            new InMemoryRuleHandlerRegistry([
                new ValidHandler(),
            ])
        );

        $errors = $validator->validate(1, new Valid());

        self::assertSame([], $errors);
    }
}
