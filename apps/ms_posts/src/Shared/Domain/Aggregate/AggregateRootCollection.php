<?php

declare(strict_types=1);

namespace Modules\Shared\Domain\Aggregate;

use Modules\Shared\Domain\Bus\Event\DomainEvent;
use Modules\Shared\Domain\Collection;

use function Lambdish\Phunctional\reduce;

abstract class AggregateRootCollection extends Collection
{
    /** @return DomainEvent[] */
    public function pullDomainEvents()
    {
        return reduce($this->pullItemDomainEvents(), $this, []);
    }

    private function pullItemDomainEvents()
    {
        return function (array $accumulatedEvents, AggregateRoot $aggregateRoot) {
            return array_merge($accumulatedEvents, $aggregateRoot->pullDomainEvents());
        };
    }
}
