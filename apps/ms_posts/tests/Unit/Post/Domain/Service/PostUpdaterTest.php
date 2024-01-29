<?php

namespace Tests\Unit\Post\Domain\Service;

use Mockery\MockInterface;
use Modules\Post\Domain\Exception\AlreadyExistsSlug;
use Modules\Post\Domain\Exception\NotFound;
use Modules\Post\Domain\Service\PostFinder;
use Modules\Post\Domain\Service\PostUpdater;
use Tests\PostTestCase;
use Tests\Unit\Post\Domain\ValueObject\PostContentMother;
use Tests\Unit\Post\Domain\ValueObject\PostTitleMother;
use Tests\Unit\Post\PostMother;
use Tests\Unit\Shared\Domain\ValueObject\DateTimeValueObjectMother;
use Tests\Unit\Shared\Domain\ValueObject\IdValueObjectMother;
use Tests\Unit\Shared\Domain\ValueObject\SlugValueObjectMother;

/**
 * Summary of PostUpdaterTest
 */
class PostUpdaterTest extends PostTestCase
{
    /**
     * Summary of postUpdater
     */
    protected PostUpdater $postUpdater;

    protected PostFinder|MockInterface $postFinder;

    protected function setUp(): void
    {
        parent::setUp();
        unset($this->postUpdater, $this->postFinder);

        $this->postFinder = new PostFinder($this->postRepository);
        $this->postUpdater = new PostUpdater(
            $this->postRepository,
            $this->postFinder
        );
    }

    /**
     * @test
     */
    public function shouldUpdatePostOk(): void
    {
        $post = PostMother::dummy();

        $this->shouldFind($post);
        $this->shouldNotFindOtherSlug();

        $params = [
            $post->id(),
            PostTitleMother::dummy(),
            SlugValueObjectMother::dummy(),
            PostContentMother::empty(),
            DateTimeValueObjectMother::dummy(),
        ];

        $this->shouldUpdateRepository($params);

        $this->postUpdater->__invoke(
            ...$params
        );

        $params = [
            'id' => $post->id(),
            'title' => PostTitleMother::dummy(),
            'slug' => SlugValueObjectMother::dummy(),
            'content' => PostContentMother::dummy(),
            'updatedAt' => DateTimeValueObjectMother::dummy(),
        ];

        $this->shouldUpdateRepository($params);

        $actual = $this->postUpdater->__invoke(
            ...$params
        );

        $this->assertNotEquals($actual['title'], $post->title());
        $this->assertNotEquals($actual['slug'], $post->slug());
        $this->assertNotEquals($actual['content'], $post->content());
        $this->assertNotEmpty($actual['content']->value());
    }

    /**
     * @test
     */
    public function shouldUpdatePostKo(): void
    {
        $this->shouldNotFind();

        $this->expectException(NotFound::class);

        $this->postUpdater->__invoke(
            IdValueObjectMother::dummy(),
            PostTitleMother::dummy(),
            SlugValueObjectMother::dummy(),
            PostContentMother::dummy(),
            DateTimeValueObjectMother::dummy(),
        );
    }

    /**
     * @test
     */
    public function shouldUpdatePostKoOtherSameSlug(): void
    {
        $post = PostMother::dummy();

        $this->shouldFind($post);
        $this->shouldFindOtherSlug($post->slug());

        $this->expectException(AlreadyExistsSlug::class);

        $this->postUpdater->__invoke(
            IdValueObjectMother::dummy(),
            PostTitleMother::dummy(),
            SlugValueObjectMother::dummy(),
            PostContentMother::dummy(),
            DateTimeValueObjectMother::dummy(),
        );
    }

    /**
     * @test
     */
    public function shouldUpdatePostOkWithoutAllFields(): void
    {
        $post = PostMother::dummy();

        $this->shouldFind($post);
        $this->shouldNotFindOtherSlug();

        $params = [
            'id' => $post->id(),
            'title' => PostTitleMother::dummy(),
            'slug' => SlugValueObjectMother::dummy(),
            'content' => PostContentMother::empty(),
            'updatedAt' => DateTimeValueObjectMother::dummy(),
        ];

        $this->shouldUpdateRepository($params);

        $actual = $this->postUpdater->__invoke(
            ...$params
        );

        $this->assertNotEquals($actual['title'], $post->title());
        $this->assertNotEquals($actual['slug'], $post->slug());
        $this->assertNotEquals($actual['content'], $post->content());
        $this->assertEmpty($actual['content']->value());
    }
}
