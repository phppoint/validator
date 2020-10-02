<?php

declare(strict_types=1);

namespace PHPyh\Validator;

use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @covers \PHPyh\Validator\Error
 *
 * @small
 */
final class ErrorTest extends TestCase
{
    public function testErrorAtProperty(): void
    {
        $error = new Error('f489b3bd-2dd0-4953-a4ca-a9c712bf38c3', 'message');

        $atProperty = $error->atProperty('a');

        self::assertSame('.a', $atProperty->path);
    }

    public function testErrorWithPathAtProperty(): void
    {
        $error = new Error('f489b3bd-2dd0-4953-a4ca-a9c712bf38c3', 'message', [], '[b]');

        $atProperty = $error->atProperty('a');

        self::assertSame('.a[b]', $atProperty->path);
    }

    public function testErrorAtOffset(): void
    {
        $error = new Error('f489b3bd-2dd0-4953-a4ca-a9c712bf38c3', 'message');

        $atProperty = $error->atOffset('a');

        self::assertSame('[a]', $atProperty->path);
    }

    public function testErrorWithPathAtOffset(): void
    {
        $error = new Error('f489b3bd-2dd0-4953-a4ca-a9c712bf38c3', 'message', [], '.b');

        $atProperty = $error->atOffset('a');

        self::assertSame('[a].b', $atProperty->path);
    }
}
