<?php

namespace Tests\Unit\Post\Domain\Service;

use Mockery\MockInterface;
use Modules\Post\Domain\Exception\NotFound;
use Modules\Post\Domain\Service\PostFinder;
use Modules\Post\Domain\Service\PostRemover;
use Tests\PostTestCase;
use Tests\Unit\Post\PostMother;

class PostRemoverTest extends PostTestCase
{
    /**
     * Summary of postRemover
     */
    protected PostRemover $postRemover;

    protected PostFinder|MockInterface $postFinder;

    public function setUp(): void
    {
        parent::setUp();
        unset($this->postRemover, $this->postFinder);

        $this->postFinder = new PostFinder($this->postRepository);
        $this->postRemover = new PostRemover(
            $this->postRepository,
            $this->postFinder
        );

    }

    /**
     * @test
     */
    public function shouldDeletePostOk(): void
    {
        $post = PostMother::dummy();

        $this->shouldFind($post);

        $this->shouldDeleteRepository();

        $this->postRemover->__invoke(
            $post->id()
        );

    }

    /**
     * @test
     */
    public function shouldDeletePostKoNotFound(): void
    {
        $post = PostMother::dummy();

        $this->shouldNotFind();

        $this->expectException(NotFound::class);

        $this->postRemover->__invoke(
            $post->id(),
        );
    }
}
