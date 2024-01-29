<?php

namespace Tests\Unit\Post\Domain\ValueObject;

use Modules\Post\Domain\ValueObject\PostTitle;
use Modules\Shared\Domain\Exception\InvalidValueException;
use Tests\PostTestCase;

class PostTitleTest extends PostTestCase
{
    /**
     * @test
     */
    public function shouldCreatePostTitleOk(): void
    {
        $value = 'lorem ipsun';
        $expected = $value;

        $return = PostTitle::from($value);

        $this->assertEquals($expected, $return->value());
    }

    /**
     * @test
     */
    public function shouldCreatePostTitleKoFormat(): void
    {
        $value = 'fo';

        $this->expectException(InvalidValueException::class);
        PostTitle::from($value);
    }

    /**
     * @test
     */
    public function shouldCreatePostTitleKo(): void
    {
        $value = 1;

        $this->expectException(InvalidValueException::class);
        PostTitle::from($value);
    }
}
