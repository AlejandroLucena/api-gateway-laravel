<?php

declare(strict_types=1);

namespace Modules\Post\Application\Command\Delete;

class DeletePostCommand
{
    public function __construct(
        private readonly string $id,
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }
}
