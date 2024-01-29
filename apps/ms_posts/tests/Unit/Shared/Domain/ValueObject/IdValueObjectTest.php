<?php

namespace Tests\Unit\Shared\Domain\ValueObject;

use Illuminate\Support\Str;
use Modules\Shared\Domain\ValueObject\IdValueObject;
use Tests\PostTestCase;

class IdValueObjectTest extends PostTestCase
{
    /**
     * @test
     */
    public function shouldCreateIdValueObjectOk(): void
    {
        $value = Str::uuid()->toString();

        $return = IdValueObject::from($value);

        $this->assertEquals(IdValueObject::class, get_class($return));
        $this->assertEquals($value, $return->value());
    }
}
