<?php

namespace App\Services;

use App\Traits\ConsumeExternalService;

class PostService
{
    use ConsumeExternalService;

    public string $baseUri = '';

    public string $secret = '';

    public function __construct()
    {
        $this->baseUri = config('microservices.posts.base_uri');
        $this->secret = config('microservices.posts.secret');
    }

    public function getPosts()
    {
        return $this->performRequest('GET', '/api/v1/posts');
    }

    public function getPost($id)
    {
        return $this->performRequest('GET', $this->baseUri. '/api/v1/posts/'.$id);
    }

    public function createPost($data)
    {
        return $this->performRequest('POST', '/api/v1/posts', $data);
    }

    public function updatePost($data, $id)
    {
        return $this->performRequest('PUT', '/api/v1/posts/'.$id, $data);
    }

    public function deletePost($id)
    {
        return $this->performRequest('DELETE', '/api/v1/posts/'.$id);
    }
}
