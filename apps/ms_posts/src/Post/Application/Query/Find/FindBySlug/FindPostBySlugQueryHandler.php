<?php

declare(strict_types=1);

namespace Modules\Post\Application\Query\Find\FindBySlug;

use Modules\Post\Domain\Service\PostFinder;
use Modules\Shared\Domain\ValueObject\SlugValueObject;

class FindPostBySlugQueryHandler
{
    public function __construct(
        private readonly PostFinder $postFinder
    ) {
    }

    public function __invoke(
        FindPostBySlugQuery $query
    ): array {
        return $this->postFinder->findBySlug(
            SlugValueObject::from($query->slug())
        );
    }
}
