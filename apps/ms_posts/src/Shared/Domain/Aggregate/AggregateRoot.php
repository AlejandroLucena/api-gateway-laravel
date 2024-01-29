<?php

declare(strict_types=1);

namespace Modules\Shared\Domain\Aggregate;

abstract class AggregateRoot
{
    private $domainEvents = [];

    final public function pullDomainEvents(): array
    {
        $domainEvents = $this->domainEvents;
        $this->domainEvents = [];

        return $domainEvents;
    }
}
