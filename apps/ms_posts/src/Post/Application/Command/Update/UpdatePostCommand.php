<?php

declare(strict_types=1);

namespace Modules\Post\Application\Command\Update;

/**
 * Summary of UpdatePostCommand
 */
class UpdatePostCommand
{
    public function __construct(
        private readonly string $id,
        private readonly ?string $title,
        private readonly ?string $slug,
        private readonly ?string $content,
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
    public function title(): ?string
    {
        return $this->title ?: '';
    }

    /**
     * Summary of slug
     */
    public function slug(): ?string
    {
        return $this->slug ?: '';
    }

    /**
     * Summary of content
     */
    public function content(): ?string
    {
        return $this->content ?: '';
    }
}
