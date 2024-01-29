<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\PostService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostController extends Controller
{
    use ApiResponser;

    public function __construct(
        private readonly PostService $postService
    ) {
    }

    public function index()
    {
        return $this->successResponse($this->postService->getPosts(), Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        return $this->successResponse($this->postService->createPost($request->all()), Response::HTTP_CREATED);
    }

    public function update(Request $request, string $id)
    {
        return $this->successResponse($this->postService->updatePost($request, $id), Response::HTTP_CREATED);
    }

    public function find(string $id)
    {
        return $this->successResponse($this->postService->getPost($id), Response::HTTP_OK);
    }

    public function destroy(string $id)
    {
    }
}
