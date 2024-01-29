<?php

declare(strict_types=1);

namespace Modules\Post\Infrastructure\Controller;

use App\Http\Requests\PostRequest;
use Modules\Post\Application\Command\Update\UpdatePostCommand;
use Modules\Shared\Infrastructure\Controller;
use Modules\Shared\Services\Commands\CommandBus;

class UpdatePostController extends Controller
{
    /**
     * Variable title
     */
    private string $title;

    /**
     * Variable slug
     */
    private string $slug;

    /**
     * Variable content
     */
    private string $content;

    public function __construct(
        private readonly CommandBus $commandBus
    ) {
    }

    public function __invoke(PostRequest $request, string $id): void
    {
        $this->validateRequest();

        $this->title = $request->input('title');
        $this->slug = $request->input('slug') ?: '';
        $this->content = $request->input('content') ?: '';

        $this->commandBus->dispatch(new UpdatePostCommand(
            $id,
            $this->title,
            $this->slug,
            $this->content,
        ));
    }
}
