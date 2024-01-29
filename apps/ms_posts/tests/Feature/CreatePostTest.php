<?php

use Illuminate\Http\Response;
use Tests\Unit\Post\Domain\ValueObject\PostContentMother;
use Tests\Unit\Post\Domain\ValueObject\PostTitleMother;
use Tests\Unit\Shared\Domain\ValueObject\SlugValueObjectMother;

it('create a post with all fields', function () {
    $params = [
        'title' => PostTitleMother::dummy()->value(),
        'slug' => SlugValueObjectMother::dummy()->value(),
        'content' => PostContentMother::dummy()->value(),
    ];

    $response = $this->post('/api/v1/posts', $params);

    $response->assertStatus(Response::HTTP_CREATED);
});

it('create a post without content', function () {
    $params = [
        'title' => PostTitleMother::dummy()->value(),
        'slug' => SlugValueObjectMother::dummy()->value(),
        'content' => PostContentMother::empty()->value(),
    ];

    $response = $this->post('/api/v1/posts', $params);

    $response->assertStatus(Response::HTTP_CREATED);
});

it('create a post without slug', function () {
    $params = [
        'title' => PostTitleMother::dummy()->value(),
        'slug' => null,
        'content' => PostContentMother::dummy()->value(),
    ];

    $response = $this->post('/api/v1/posts', $params);

    $actual = json_decode($response->getContent())->data;

    expect($actual->title)->toEqual($params['title']);
    expect($actual->slug)->not->toEqual($params['slug']);
    expect($actual->content)->toEqual($params['content']);
});
