<?php

declare(strict_types=1);

namespace Modules\Post\Domain\Exception;

use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;

final class InvalidTitle extends InvalidArgumentException
{
    public static function reason(string $msg): InvalidTitle
    {
        return new self('Invalid Post title because '.$msg, Response::HTTP_BAD_REQUEST);
    }
}
