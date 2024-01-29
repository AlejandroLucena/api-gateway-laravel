<?php

namespace Tests\Unit\Shared\Domain\ValueObject;

use Modules\Shared\Domain\Exception\InvalidValueException;
use Modules\Shared\Domain\ValueObject\SlugValueObject;
use Tests\PostTestCase;

class SlugValueObjectTest extends PostTestCase
{
    /**
     * @test
     */
    public function shouldCreateSlugValueObjectOk(): void
    {
        $value = 'lorem-ipsun';
        $expected = $value;

        $return = SlugValueObject::from($value);

        $this->assertEquals($expected, $return->value());
    }

    /**
     * @test
     */
    public function shouldCreateSlugValueObjectKoFormat(): void
    {
        $value = 'fo ';

        $this->expectException(InvalidValueException::class);
        SlugValueObject::from($value);
    }
}
