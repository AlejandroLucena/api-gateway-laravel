<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Mockery\MockInterface;
use Modules\Post\Domain\Contract\PostRepository;
use Modules\Post\Domain\Exception\AlreadyExists;
use Modules\Post\Domain\Exception\AlreadyExistsSlug;
use Modules\Post\Domain\Exception\NotFound;
use Modules\Post\Domain\Post;
use Modules\Post\Domain\Service\PostFinder;
use Modules\Shared\Domain\ValueObject\IdValueObject;
use Modules\Shared\Domain\ValueObject\SlugValueObject;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class PostTestCase extends TestCase
{
    use RefreshDatabase;

    protected PostRepository|MockInterface $postRepository;

    protected PostFinder|MockInterface $postFinder;

    protected function setUp(): void
    {
        unset($this->postRepository);

        $this->postRepository = Mockery::mock(PostRepository::class);

        parent::setUp();
    }

    public function shouldSaveRepository(Post $post): void
    {
        $this->postRepository
            ->shouldReceive('save')
            ->once()
            ->andReturn($post->toPrimitives());
    }

    public function shouldUpdateRepository(array $response): void
    {
        $this->postRepository
            ->shouldReceive('update')
            ->once()
            ->andReturn($response);
    }

    public function shouldNotSaveRepository(): void
    {
        $this->postRepository
            ->shouldReceive('save')
            ->andThrow(BadRequestException::class);
    }

    public function shouldDeleteRepository(): void
    {
        $this->postRepository
            ->shouldReceive('delete')
            ->once();
    }

    public function shouldFind(Post $post): void
    {
        $this->postRepository
            ->shouldReceive('find')
            ->andReturn($post->toPrimitives());
    }

    public function shouldFindSlugFails(): void
    {
        $this->postRepository
            ->shouldReceive('findBySlug')
            ->andThrow(AlreadyExists::class);
    }

    public function shouldNotFind(): void
    {
        $this->postRepository
            ->shouldReceive('find')
            ->andThrow(NotFound::class);
    }

    public function shouldFindOrFail(Post $post): void
    {
        $this->postRepository
            ->shouldReceive('findOrFail')
            ->with($post->id())
            ->andReturn($post->toPrimitives());
    }

    public function shouldNotFindOrFail(IdValueObject $id): void
    {
        $this->postRepository
            ->shouldReceive('findOrFail')
            ->andThrow(NotFound::with($id));
    }

    public function shouldFindOtherSlug(SlugValueObject $slug): void
    {
        $this->postRepository
            ->shouldReceive('findBySlug')
            ->andThrow(AlreadyExistsSlug::with($slug));
    }

    public function shouldNotFindOtherSlug(): void
    {
        $this->postRepository
            ->shouldReceive('findBySlug')
            ->andReturnNull();
    }

    public function shouldDelete(): void
    {
        $this->postRepository
            ->shouldReceive('delete')
            ->once();
    }
}
