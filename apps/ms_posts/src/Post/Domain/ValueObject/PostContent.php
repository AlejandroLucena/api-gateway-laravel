<?php

declare(strict_types=1);

namespace Modules\Post\Domain\ValueObject;

use Modules\Shared\Domain\ValueObject\StringValueObject;

final class PostContent extends StringValueObject
{
    public function __construct(string $value = '')
    {
        parent::__construct($value);
    }

    public static function from(string $value = ''): self
    {
        return new self($value);
    }
}
