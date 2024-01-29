<?php

declare(strict_types=1);

namespace Modules\Post\Domain\Service;

use Modules\Post\Domain\Contract\PostRepository;
use Modules\Post\Domain\Exception\AlreadyExistsSlug;
use Modules\Post\Domain\Exception\NotFound;
use Modules\Post\Domain\Post;
use Modules\Post\Domain\ValueObject\PostContent;
use Modules\Post\Domain\ValueObject\PostTitle;
use Modules\Shared\Domain\ValueObject\DateTimeValueObject;
use Modules\Shared\Domain\ValueObject\IdValueObject;
use Modules\Shared\Domain\ValueObject\SlugValueObject;

class PostUpdater
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
        PostContent $content,
        DateTimeValueObject $updatedAt
    ): array {

        $post = $this->ensureExists($id); //find

        $this->ensureDoesNotExistsSlug($id, $slug); //findBySlug

        $post->update(
            $id,
            $title ? $title : $post->title(),
            $slug ? $slug : $post->slug(),
            $content != '' ? $content : $post->content(),
            $updatedAt
        );

        $response = $this->postRepository->update($post);

        return $response;
    }

    private function ensureExists(IdValueObject $id): ?Post
    {
        $response = $this->postFinder->find($id);

        if (empty($response)) {
            throw NotFound::with($id);
        }

        return Post::fromValueObjects($response);
    }

    private function ensureDoesNotExistsSlug(IdValueObject $id, SlugValueObject $slug): void
    {
        $response = $this->postFinder->findBySlug($slug);
        if ($response && $response['id'] != $id->value()) {
            throw AlreadyExistsSlug::with($slug);
        }
    }
}
