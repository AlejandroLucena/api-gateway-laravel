<?php

namespace Tests\Unit\Post\Domain\ValueObject;

use Faker\Factory;
use Modules\Post\Domain\ValueObject\PostContent;
use Tests\PostTestCase;

class PostContentTest extends PostTestCase
{
    /**
     * @test
     */
    public function shouldCreatePostContentOk(): void
    {
        $paragraph = Factory::create()->paragraph();

        $return = PostContent::from($paragraph);

        $this->assertEquals($paragraph, $return->value());
    }

    /**
     * @test
     */
    public function shouldCreatePostContentKo(): void
    {
        $value = 1;
        $expected = $value;

        $return = PostContent::from($value);

        $this->assertNotEquals(gettype($expected), gettype($return->value()));
    }
}
