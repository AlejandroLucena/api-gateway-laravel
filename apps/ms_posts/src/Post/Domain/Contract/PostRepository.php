<?php

declare(strict_types=1);

namespace Modules\Post\Domain\Contract;

use Modules\Post\Domain\Post;
use Modules\Shared\Domain\Criteria\Criteria;
use Modules\Shared\Domain\ValueObject\IdValueObject;
use Modules\Shared\Domain\ValueObject\SlugValueObject;

interface PostRepository
{
    public function save(Post $post): array;

    public function update(Post $post): array;

    public function find(IdValueObject $id): ?array;

    public function findBySlug(SlugValueObject $slug): ?array;

    public function findAll(): array;

    public function matching(Criteria $criteria): array;

    public function delete(IdValueObject $id): void;
}
