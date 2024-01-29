<?php

namespace Tests\Unit\Shared\Domain\ValueObject;

use Illuminate\Support\Str;
use Modules\Shared\Domain\ValueObject\IdValueObject;

class IdValueObjectMother
{
    public static function dummy(): IdValueObject
    {
        return IdValueObject::from(Str::uuid()->toString());
    }

    public static function with(string $id): IdValueObject
    {
        return IdValueObject::from($id);
    }
}
