<?php

declare(strict_types=1);

namespace Modules\Post\Domain\Service;

use Modules\Post\Domain\Contract\PostRepository;
use Modules\Post\Domain\Exception\NotFound;
use Modules\Shared\Domain\ValueObject\IdValueObject;
use Modules\Shared\Domain\ValueObject\SlugValueObject;

class PostFinder
{
    public function __construct(
        private readonly PostRepository $postRepository,
    ) {
    }

    public function findAll(): array
    {
        $post = $this->postRepository->findAll();

        return $post;
    }

    public function find(IdValueObject $id): ?array
    {
        $post = $this->postRepository->find($id);

        return $post;
    }

    public function findOrFail(IdValueObject $id): array
    {
        $post = $this->postRepository->find($id);

        if (empty($post)) {
            throw NotFound::with($id);
        }

        return $post;
    }

    public function findBySlug(SlugValueObject $slug): ?array
    {
        $post = $this->postRepository->findBySlug($slug);

        return $post;
    }

    public function findBySlugOrFail(SlugValueObject $slug): array
    {
        $post = $this->postRepository->findBySlug($slug);

        if (! $post) {
            throw NotFound::withSlug($slug);
        }

        return $post;
    }
}
