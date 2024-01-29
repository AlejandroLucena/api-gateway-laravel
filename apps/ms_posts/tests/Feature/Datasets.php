<?php

use Tests\Unit\Post\Domain\ValueObject\PostContentMother;
use Tests\Unit\Post\Domain\ValueObject\PostTitleMother;
use Tests\Unit\Shared\Domain\ValueObject\SlugValueObjectMother;

dataset('validValues', [
    [
        'title' => PostTitleMother::dummy()->value(),
        'slug' => SlugValueObjectMother::dummy()->value(),
        'content' => PostContentMother::dummy()->value(),
    ],
    [
        'title' => PostTitleMother::dummy()->value(),
        'slug' => SlugValueObjectMother::dummy()->value(),
        'content' => PostContentMother::empty()->value(),
    ],
]);
