<?php

declare(strict_types=1);

namespace Modules\Post\Domain;

use Modules\Post\Domain\ValueObject\PostContent;
use Modules\Post\Domain\ValueObject\PostTitle;
use Modules\Shared\Domain\ValueObject\DateTimeValueObject;
use Modules\Shared\Domain\ValueObject\IdValueObject;
use Modules\Shared\Domain\ValueObject\SlugValueObject;

class Post
{
    private ?DateTimeValueObject $deletedAt;

    public function __construct(
        private IdValueObject $id,
        private PostTitle $title,
        private ?SlugValueObject $slug,
        private ?PostContent $content,
        private DateTimeValueObject $createdAt,
        private ?DateTimeValueObject $updatedAt = null,
    ) {
        $this->deletedAt = null;
    }

    public function id(): IdValueObject
    {
        return $this->id;
    }

    public function title(): PostTitle
    {
        return $this->title;
    }

    public function slug(): ?SlugValueObject
    {
        return $this->slug ?: null;
    }

    public function content(): ?PostContent
    {
        return $this->content ?: null;
    }

    public function createdAt(): DateTimeValueObject
    {
        return $this->createdAt;
    }

    public function updatedAt(): ?DateTimeValueObject
    {
        return $this->updatedAt ?: null;
    }

    public function deletedAt(): ?DateTimeValueObject
    {
        return $this->deletedAt ?: null;
    }

    public static function create(
        IdValueObject $id,
        PostTitle $title,
        SlugValueObject $slug,
        PostContent $content,
        DateTimeValueObject $createdAt,
    ): Post {

        return new self(
            $id,
            $title,
            $slug,
            $content,
            $createdAt
        );
    }

    public function update(
        IdValueObject $id,
        PostTitle $title,
        SlugValueObject $slug,
        PostContent $content,
        DateTimeValueObject $updateAt,
    ): self {
        $this->id = $id;
        $this->title = $title;
        $this->slug = $slug;
        $this->content = $content;
        $this->updatedAt = $updateAt;

        return $this;
    }

    /**
     * Summary of delete
     */
    public function delete(): void
    {
        $this->deletedAt = DateTimeValueObject::now();
    }

    public static function fromPrimitives(array $primitives): self
    {
        return new self(
            IdValueObject::from($primitives['id']),
            PostTitle::from($primitives['title']),
            SlugValueObject::from($primitives['slug']),
            PostContent::from($primitives['content']),
            DateTimeValueObject::createFromString($primitives['created_at']),
            DateTimeValueObject::createFromString($primitives['updated_at'])
        );
    }

    public static function fromValueObjects(array $valueObjects): self
    {
        return new self(
            IdValueObject::from($valueObjects['id']),
            PostTitle::from($valueObjects['title']),
            SlugValueObject::from($valueObjects['slug']),
            PostContent::from($valueObjects['content']),
            DateTimeValueObject::createFromString($valueObjects['created_at']),
            DateTimeValueObject::createFromString($valueObjects['updated_at'])
        );
    }

    public function toPrimitives(): array
    {
        return [
            'id' => $this->id()->value(),
            'title' => $this->title()->value(),
            'slug' => $this->slug()->value(),
            'content' => $this->content()->value(),
            'created_at' => $this->createdAt() ? $this->createdAt()->toIso8601Format() : null,
            'updated_at' => $this->updatedAt() ? $this->updatedAt()->toIso8601Format() : null,
        ];
    }
}
