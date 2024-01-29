<?php

namespace Tests\Unit\Post\Domain\ValueObject;

use Illuminate\Support\Str;
use Modules\Post\Domain\ValueObject\PostContent;

class PostContentMother
{
    public static function dummy(): PostContent
    {
        return PostContent::from(Str::random(10));
    }

    public static function with(string $string): PostContent
    {
        return PostContent::from($string);
    }

    public static function empty(): PostContent
    {
        return self::with('');
    }
}
