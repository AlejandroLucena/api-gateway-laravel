<?php

namespace Tests\Unit\Shared\Domain\ValueObject;

use Illuminate\Support\Str;
use Modules\Shared\Domain\ValueObject\SlugValueObject;

class SlugValueObjectMother
{
    public static function dummy(): SlugValueObject
    {
        return SlugValueObject::from(Str::slug(Str::random(30)));
    }

    public static function from(?string $string = null): SlugValueObject
    {
        return SlugValueObject::from(Str::slug($string));
    }

    public static function with(string $string)
    {
        return self::from($string);
    }

    public static function empty(): SlugValueObject
    {
        return self::from('');
    }
}
