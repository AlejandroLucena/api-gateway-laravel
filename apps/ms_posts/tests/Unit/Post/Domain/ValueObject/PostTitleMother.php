<?php

namespace Tests\Unit\Post\Domain\ValueObject;

use Illuminate\Support\Str;
use Modules\Post\Domain\ValueObject\PostTitle;

class PostTitleMother
{
    public static function dummy(): PostTitle
    {
        return PostTitle::from(Str::random(10));
    }

    public static function with(string $string): PostTitle
    {
        return PostTitle::from($string);
    }

    public static function empty(): PostTitle
    {
        return self::with('');
    }
}
