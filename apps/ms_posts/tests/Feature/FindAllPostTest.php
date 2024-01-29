<?php

namespace Tests\Feature;

use Illuminate\Http\Response;
use Tests\Seeders\PostsTestSeeder;

beforeEach(function () {
    $this->seed(PostsTestSeeder::class);
});

it('find all post', function () {
    $response = $this->get('/api/v1/posts');
    $actual = json_decode($response->getContent())->data;

    expect(count($actual))->toEqual(10);
    $response->assertStatus(Response::HTTP_OK);
});
