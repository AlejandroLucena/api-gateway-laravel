<?php

declare(strict_types=1);

namespace Modules\Post\Domain\Service;

use Modules\Post\Domain\Contract\PostRepository;
use Modules\Post\Domain\Exception\AlreadyExists;
use Modules\Post\Domain\Exception\AlreadyExistsSlug;
use Modules\Post\Domain\Post;
use Modules\Post\Domain\ValueObject\PostContent;
use Modules\Post\Domain\ValueObject\PostTitle;
use Modules\Shared\Domain\ValueObject\DateTimeValueObject;
use Modules\Shared\Domain\ValueObject\IdValueObject;
use Modules\Shared\Domain\ValueObject\SlugValueObject;

class PostCreator
{
    public function __construct(
        private readonly PostRepository $postRepository,
        private readonly PostFinder $postFinder
    ) {
    }

    public function __invoke(
        IdValueObject $id,
        PostTitle $title,
        SlugValueObject $slug,
        ?PostContent $content,
        DateTimeValueObject $createdAt
    ): array {

        $this->ensureDoesNotExistsSlug($slug);

        $post = new Post(
            $id,
            $title,
            $slug,
            $content,
            $createdAt
        );

        $response = $this->postRepository->save($post);
        return $response;
    }

    private function ensureDoesNotExistsSlug(SlugValueObject $slug): void
    {
        $post = $this->postFinder->findBySlug($slug);
        if ($post) {
            throw AlreadyExistsSlug::with($slug);
        }
    }
}
