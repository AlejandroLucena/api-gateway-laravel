<?php

namespace App\Http\Controllers\Api\v1\Post;

use App\Http\Controllers\Api\ApiController;
use App\Services\PostService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostController extends ApiController
{
    use ApiResponser;

    public PostService $postService;

    public function __construct(PostService $postService)
    {

        $this->postService = $postService;
    }

    public function index()
    {
        return $this->successResponse($this->postService->getPosts(), Response::HTTP_OK);
    }

    public function find(string $id)
    {
        return $this->successResponse($this->postService->getPost($id), Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        return $this->successResponse($this->postService->createPost($request->all()), Response::HTTP_CREATED);
    }

    public function update(Request $request, string $id)
    {
        return $this->successResponse($this->postService->editPost($request->all(), $id), Response::HTTP_CREATED);
    }

    public function delete(string $id)
    {
        return $this->successResponse($this->postService->deletePost($id), Response::HTTP_NO_CONTENT);
    }
}
