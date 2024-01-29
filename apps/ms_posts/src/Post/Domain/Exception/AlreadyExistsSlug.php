<?php

/**
 * This file is part of prooph/proophessor-do.
 * (c) 2014-2018 prooph software GmbH <contact@prooph.de>
 * (c) 2015-2018 Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Modules\Post\Domain\Exception;

use Modules\Shared\Domain\ValueObject\SlugValueObject;
use Symfony\Component\HttpFoundation\Response;

final class AlreadyExistsSlug extends \InvalidArgumentException
{
    public static function with(SlugValueObject $slug): self
    {
        return new self(\sprintf('Post with slug %s already exists.', $slug->value()), Response::HTTP_BAD_REQUEST);
    }
}
