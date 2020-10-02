<?php

declare(strict_types=1);

namespace PHPyh\Validator;

/**
 * @psalm-immutable
 */
final class Error
{
    private const INVALID_TYPE = '9ab3eec6-ec67-4968-afc1-5e7c2ec477f4';

    public string $code;

    public string $message;

    /**
     * @psalm-var array<string, mixed>
     */
    public array $variables;

    public string $path;

    /**
     * @psalm-param array<string, mixed> $variables
     */
    public function __construct(string $code, string $message, array $variables = [], string $path = '')
    {
        $this->code = $code;
        $this->message = $message;
        $this->variables = $variables;
        $this->path = $path;
    }

    /**
     * @param mixed $value
     */
    public static function invalidType($value, string $expectedType, string ...$expectedTypes): self
    {
        return new self(
            self::INVALID_TYPE,
            'Invalid type {actual_type}, expected {expected_types}',
            [
                'actual_type' => get_debug_type($value),
                'expected_types' => implode('|', [$expectedType, ...$expectedTypes]),
            ]
        );
    }

    public function atProperty(string $property): self
    {
        $error = clone $this;
        $error->path = sprintf('.%s%s', $property, $this->path);

        return $error;
    }

    public function atOffset(string $offset): self
    {
        $error = clone $this;
        $error->path = sprintf('[%s]%s', $offset, $this->path);

        return $error;
    }
}
