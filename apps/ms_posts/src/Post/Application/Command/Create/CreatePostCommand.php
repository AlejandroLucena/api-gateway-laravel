<?php

declare(strict_types=1);

namespace Modules\Post\Application\Command\Create;

use Illuminate\Support\Str;
use Modules\Shared\Services\Commands\Command;

/**
 * Summary of CreatePostCommand
 */
class CreatePostCommand extends Command
{
    /**
     * Summary of __construct
     */
    public function __construct(
        private readonly string $id,
        private readonly string $title,
        private readonly ?string $slug = null,
        private readonly ?string $content = null,
    ) {
    }

    /**
     * Summary of id
     */
    public function id(): string
    {
        return $this->id;
    }

    /**
     * Summary of title
     */
    public function title(): string
    {
        return $this->title;
    }

    /**
     * Summary of slug
     */
    public function slug(): ?string
    {
        return $this->slug ?: Str::slug($this->title);
    }

    /**
     * Summary of postContent
     */
    public function content(): ?string
    {
        return $this->content ?: '';
    }
}
