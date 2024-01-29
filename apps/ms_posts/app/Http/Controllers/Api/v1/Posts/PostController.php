<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\v1\Posts;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\PostRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Post\Infrastructure\Controller\CreatePostController;
use Modules\Post\Infrastructure\Controller\DeletePostController;
use Modules\Post\Infrastructure\Controller\FindAllPostsController;
use Modules\Post\Infrastructure\Controller\FindPostByIdController;
use Modules\Post\Infrastructure\Controller\UpdatePostController;

class PostController extends ApiController
{
    public function __construct(
        private readonly CreatePostController $createPostController,
        private readonly UpdatePostController $updatePostController,
        private readonly DeletePostController $deletePostController,
        private readonly FindAllPostsController $findAllPostsController,
        private readonly FindPostByIdController $findPostByIdController,
    ) {
        //
    }

    public function store(Request $request)
    {
        try {
            $id = $this->createPostController->__invoke($request);

            $post = $this->findPostByIdController->__invoke($id);

            return response()->json(
                [
                    'message' => 'Entity Created',
                    'data' => [
                        ...$post,
                    ],
                ],
                Response::HTTP_CREATED);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(PostRequest $request, string $id)
    {
        try {
            $this->updatePostController->__invoke($request, $id);

            return response()->json('Entity Updated', Response::HTTP_ACCEPTED);
        } catch (Exception $e) {

            return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function delete(string $id)
    {
        try {
            $this->deletePostController->__invoke($id);

            return response()->json('Entity Deleted', Response::HTTP_NO_CONTENT);
        } catch (Exception $e) {

            return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function get()
    {
        try {
            $response = $this->findAllPostsController->__invoke();

            return response()->json(
                [
                    'message' => 'Find All Posts',
                    'count' => count($response),
                    'data' => [
                        ...$response,
                    ],
                ],
                Response::HTTP_OK);
        } catch (Exception $e) {

            return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function find(string $id)
    {
        try {
            $response = $this->findPostByIdController->__invoke($id);

            return response()->json(
                [
                    'message' => 'Entity Found',
                    'data' => [
                        ...$response,
                    ],
                ], Response::HTTP_OK);
        } catch (Exception $e) {

            return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
