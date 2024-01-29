<?php

declare(strict_types=1);

namespace Modules\Post\Infrastructure\Controller;

use Modules\Post\Application\Command\Delete\DeletePostCommand;
use Modules\Shared\Infrastructure\Controller;
use Modules\Shared\Services\Commands\CommandBus;

class DeletePostController extends Controller
{
    public function __construct(
        private readonly CommandBus $commandBus
    ) {
    }

    public function __invoke(string $id): void
    {
        $this->commandBus->dispatch(new DeletePostCommand(
            $id
        ));
    }
}
