<?php

declare(strict_types=1);

namespace Modules\Post\Application\Command\Delete;

use Modules\Post\Domain\Service\PostRemover;
use Modules\Shared\Domain\ValueObject\IdValueObject;

/**
 * Summary of DeletePostCommandHandler
 */
class DeletePostCommandHandler
{
    public function __construct(
        private readonly PostRemover $postRemover,
    ) {
    }

    /**
     * Undocumented function
     */
    public function __invoke(
        DeletePostCommand $command
    ): void {
        $this->postRemover->__invoke(
            IdValueObject::from($command->id()),
        );
    }
}
