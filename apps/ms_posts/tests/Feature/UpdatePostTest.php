<?php

use Tests\Unit\Post\Domain\ValueObject\PostContentMother;
use Tests\Unit\Post\Domain\ValueObject\PostTitleMother;
use Tests\Unit\Shared\Domain\ValueObject\SlugValueObjectMother;

beforeEach(function () {
    $params = [
        'title' => PostTitleMother::dummy()->value(),
        'slug' => SlugValueObjectMother::dummy()->value(),
        'content' => PostContentMother::dummy()->value(),
    ];
    $this->response = $this->post('/api/v1/posts', $params);
    $this->expected = json_decode($this->response->getContent())->data;
});

it('update a post with all fields', function () {

    $params = [
        'title' => PostTitleMother::dummy()->value(),
        'slug' => SlugValueObjectMother::dummy()->value(),
        'content' => PostContentMother::dummy()->value(),
    ];
    $this->patch('/api/v1/posts/'.$this->expected->id, $params);

    $response = $this->get('/api/v1/posts/'.$this->expected->id);

    $actual = json_decode($response->getContent())->data;

    expect($this->expected->id)->toEqual($actual->id);
    expect($this->expected->title)->not->toEqual($actual->title);
    expect($this->expected->slug)->not->toEqual($actual->slug);
    expect($this->expected->content)->not->toEqual($actual->content);
});

it('update a post with only one fields', function () {

    $params = [
        'title' => PostTitleMother::dummy()->value(),
    ];
    $this->patch('/api/v1/posts/'.$this->expected->id, $params);

    $response = $this->get('/api/v1/posts/'.$this->expected->id);

    $actual = json_decode($response->getContent())->data;

    expect($this->expected->id)->toEqual($actual->id);
    expect($this->expected->title)->not->toEqual($actual->title);
    expect($this->expected->slug)->not->toEqual($actual->slug);
    expect($this->expected->content)->toEqual($actual->content);
});
