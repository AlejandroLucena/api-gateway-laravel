<?php

use Illuminate\Http\Response;
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

it('try to delete a post that exists', function () {

    $response = $this->delete('/api/v1/posts/'.$this->expected->id);

    expect($response->status())->toEqual(Response::HTTP_NO_CONTENT);
});
