<?php

declare(strict_types=1);

namespace Modules\Shared\Domain\ValueObject;

use Modules\Shared\Domain\Exception\InvalidValueException;

class SlugValueObject extends StringValueObject
{
    public function __construct(string $value)
    {
        $this->ensureIsValidSlug($value);

        parent::__construct($value);
    }

    private function ensureIsValidSlug(string $value)
    {
        if (! preg_match('/^[a-z0-9][-a-z0-9]*$/', $value)) {
            throw new InvalidValueException(sprintf('The slug <%s> is not valid', $value));
        }
    }

    public static function from(string $value): self
    {
        return new self($value);
    }
}
