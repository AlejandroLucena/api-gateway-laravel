<?php

declare(strict_types=1);

namespace Modules\Shared\Domain\ValueObject;

class IdValueObject extends UuidValueObject
{
    public function __construct(private readonly string $value)
    {
    }

    public function value(): string
    {
        return $this->value ? $this->value : '';
    }

    public static function from(?string $value = null): ?self
    {
        return $value ? new self((string) $value) : null;
    }
}
