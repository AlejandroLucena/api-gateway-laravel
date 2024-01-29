<?php

declare(strict_types=1);

namespace Modules\Post\Domain\Service;

use Modules\Post\Domain\Contract\PostRepository;
use Modules\Shared\Domain\Criteria\Criteria;
use Modules\Shared\Domain\Criteria\Filters;
use Modules\Shared\Domain\Criteria\Order;

final class PostsSearcher
{
    public function __construct(
        private readonly PostRepository $postRepository
    ) {
    }

    public function search(Filters $filters, Order $order, ?int $limit, ?int $offset): ?array
    {
        $criteria = new Criteria($filters, $order, $offset, $limit);

        return [];
    }
}
