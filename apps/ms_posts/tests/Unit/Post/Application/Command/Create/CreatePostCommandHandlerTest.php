<?php

declare(strict_types=1);

use Mockery\MockInterface;
use Modules\Post\Application\Command\Create\CreatePostCommand;
use Modules\Post\Application\Command\Create\CreatePostCommandHandler;
use Modules\Post\Domain\Service\PostCreator;
use Tests\PostTestCase;
use Tests\Unit\Post\Domain\ValueObject\PostContentMother;
use Tests\Unit\Post\Domain\ValueObject\PostTitleMother;
use Tests\Unit\Shared\Domain\ValueObject\IdValueObjectMother;
use Tests\Unit\Shared\Domain\ValueObject\SlugValueObjectMother;

class CreatePostCommandHandlerTest extends PostTestCase
{
    /**
     * Summary of postCreator
     *
     * @var CreatePostCommandHandler
     */
    protected CreatePostCommand|MockInterface $createPostCommand;

    protected CreatePostCommandHandler $createPostCommandHandler;

    protected PostCreator|MockInterface $postCreator;

    public function setUp(): void
    {
        $this->postCreator = $this->getMockBuilder(
            PostCreator::class,
        )->disableOriginalConstructor()->getMock();

        parent::setUp();
    }

    /**
     * @test
     *
     * @dataProvider validValues
     */
    public function testHandlerOk($validValues): void
    {
        $payload = json_decode($validValues, true, 512, JSON_THROW_ON_ERROR);

        $this->createPostCommandHandler = new CreatePostCommandHandler($this->postCreator);

        $this->expectNotToPerformAssertions();

        $this->createPostCommandHandler->__invoke(new CreatePostCommand(
            ...$payload
        ));
    }

    public static function validValues()
    {
        return [
            [
                json_encode([
                    'id' => IdValueObjectMother::dummy()->value(),
                    'title' => PostTitleMother::dummy()->value(),
                    'slug' => SlugValueObjectMother::dummy()->value(),
                    'content' => PostContentMother::dummy()->value(),
                ]),
            ],
            [
                json_encode([
                    'id' => IdValueObjectMother::dummy()->value(),
                    'title' => PostTitleMother::dummy()->value(),
                    'slug' => SlugValueObjectMother::dummy()->value(),
                    'content' => PostContentMother::empty()->value(),
                ]),
            ],
        ];
    }
}
