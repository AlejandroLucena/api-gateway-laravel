<?php

namespace Tests\Unit\Post\Domain\Service;

use Mockery\MockInterface;
use Modules\Post\Domain\Exception\AlreadyExists;
use Modules\Post\Domain\Service\PostCreator;
use Modules\Post\Domain\Service\PostFinder;
use Modules\Shared\Domain\Exception\InvalidValueException;
use Tests\PostTestCase;
use Tests\Unit\Post\Domain\ValueObject\PostContentMother;
use Tests\Unit\Post\Domain\ValueObject\PostTitleMother;
use Tests\Unit\Post\PostMother;
use Tests\Unit\Shared\Domain\ValueObject\DateTimeValueObjectMother;
use Tests\Unit\Shared\Domain\ValueObject\IdValueObjectMother;
use Tests\Unit\Shared\Domain\ValueObject\SlugValueObjectMother;

/**
 * Summary of PostCreatorTest
 */
class PostCreatorTest extends PostTestCase
{
    /**
     * Summary of postCreator
     */
    protected PostCreator $postCreator;

    protected PostFinder|MockInterface $postFinder;

    protected function setUp(): void
    {
        parent::setUp();
        unset($this->postCreator, $this->postFinder);

        $this->postFinder = new PostFinder($this->postRepository);
        $this->postCreator = new PostCreator(
            $this->postRepository,
            $this->postFinder
        );

    }

    /**
     * @test
     */
    public function shouldCreatePostOk(): void
    {
        $post = PostMother::dummy();

        $this->shouldNotFindOtherSlug();

        $this->shouldSaveRepository($post);

        $response = $this->postCreator->__invoke(
            $post->id(),
            PostTitleMother::dummy(),
            SlugValueObjectMother::dummy(),
            PostContentMother::dummy(),
            DateTimeValueObjectMother::dummy(),
        );

        $this->assertEquals($response['id'], $post->id());
    }

    /**
     * @test
     */
    public function shouldCreatePostOkWithoutSlug(): void
    {
        $id = IdValueObjectMother::dummy();

        $this->shouldNotFindOtherSlug();

        $this->expectException(InvalidValueException::class);

        $this->postCreator->__invoke(
            $id,
            PostTitleMother::dummy(),
            SlugValueObjectMother::empty(),
            PostContentMother::dummy(),
            DateTimeValueObjectMother::dummy(),
        );
    }

    /**
     * @test
     */
    public function shouldCreatePostKoWithoutTitle(): void
    {
        $id = IdValueObjectMother::dummy();

        $this->shouldNotFindOtherSlug();

        $this->expectException(InvalidValueException::class);

        $this->postCreator->__invoke(
            $id,
            PostTitleMother::empty(),
            SlugValueObjectMother::dummy(),
            PostContentMother::dummy(),
            DateTimeValueObjectMother::dummy(),
        );
    }

    /**
     * @test
     */
    public function shouldCreatePostKoAlreadyExistsSlug(): void
    {
        $id = IdValueObjectMother::dummy();

        $this->shouldFindSlugFails();

        $this->expectException(AlreadyExists::class);

        $this->postCreator->__invoke(
            $id,
            PostTitleMother::dummy(),
            SlugValueObjectMother::dummy(),
            PostContentMother::dummy(),
            DateTimeValueObjectMother::dummy(),
        );
    }
}
