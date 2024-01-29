<?php

namespace Tests\Unit\Post;

use Modules\Post\Domain\Post;
use Tests\Unit\Post\Domain\ValueObject\PostContentMother;
use Tests\Unit\Post\Domain\ValueObject\PostTitleMother;
use Tests\Unit\Shared\Domain\ValueObject\DateTimeValueObjectMother;
use Tests\Unit\Shared\Domain\ValueObject\IdValueObjectMother;
use Tests\Unit\Shared\Domain\ValueObject\SlugValueObjectMother;

class PostMother
{
    public static function dummy(): Post
    {
        $values = [
            'id' => IdValueObjectMother::dummy(),
            'title' => PostTitleMother::dummy(),
            'slug' => SlugValueObjectMother::dummy(),
            'content' => PostContentMother::dummy(),
            'created_at' => DateTimeValueObjectMother::dummy(),
            'updated_at' => DateTimeValueObjectMother::dummy(),
        ];

        $post = Post::create(
            $values['id'],
            $values['title'],
            $values['slug'],
            PostContentMother::with('Created'),
            $values['created_at'],
        );

        return $post;
    }

    public static function withTitle(string $value): Post
    {
        $title = PostTitleMother::with($value);

        $values = [
            'id' => IdValueObjectMother::dummy(),
            'title' => PostTitleMother::dummy(),
            'slug' => SlugValueObjectMother::dummy(),
            'content' => PostContentMother::dummy(),
            'created_at' => DateTimeValueObjectMother::dummy(),
            'updated_at' => DateTimeValueObjectMother::dummy(),
        ];

        $post = Post::create(
            $values['id'],
            $values['title'],
            $values['slug'],
            $values['content'],
            $values['created_at'],
        );

        $post->update(
            $values['id'],
            $title,
            $values['slug'],
            PostContentMother::with('Updated'),
            $values['created_at'],
        );

        return $post;
    }

    public static function emptyTitle(): Post
    {
        return self::withTitle('');
    }
}
