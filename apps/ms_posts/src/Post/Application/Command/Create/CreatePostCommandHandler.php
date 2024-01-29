<?php

declare(strict_types=1);

namespace Modules\Post\Application\Command\Create;

use Illuminate\Support\Str;
use Modules\Post\Domain\Service\PostCreator;
use Modules\Post\Domain\ValueObject\PostContent;
use Modules\Post\Domain\ValueObject\PostTitle;
use Modules\Shared\Domain\ValueObject\DateTimeValueObject;
use Modules\Shared\Domain\ValueObject\IdValueObject;
use Modules\Shared\Domain\ValueObject\SlugValueObject;

/**
 * Summary of CreatePostCommandHandler
 */
class CreatePostCommandHandler
{
    public function __construct(
        private readonly PostCreator $postCreator
    ) {
    }

    /**
     * Summary of handle
     */
    public function __invoke(
        CreatePostCommand $command
    ): array {
        $response = $this->postCreator->__invoke(
            IdValueObject::from($command->id()),
            PostTitle::from($command->title()),
            $command->slug() ? SlugValueObject::from($command->slug()) : SlugValueObject::from(Str::slug($command->title())),
            PostContent::from($command->content()),
            DateTimeValueObject::now()
        );

        return $response;
    }
}
