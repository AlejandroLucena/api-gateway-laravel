<?php

declare(strict_types=1);

namespace Modules\Post\Infrastructure\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\Post\Application\Command\Create\CreatePostCommand;
use Modules\Shared\Infrastructure\Controller;
use Modules\Shared\Services\Commands\CommandBus;

/**
 * Summary of CreatePostControlled
 */
class CreatePostController extends Controller
{
    private string $id;

    private string $title;

    private string $slug;

    private string $content;

    public function __construct(
        private readonly CommandBus $commandBus
    ) {
    }

    /**
     * Summary of __invoke
     */
    public function __invoke(Request $request): string
    {
        $this->id = Str::uuid()->toString();
        $this->title = $request->input('title') ? $request->input('title') : 'hola';
        $this->slug = $request->input('slug') ? $request->input('slug') : '';
        $this->content = $request->input('content') ?: '';
        
        $this->commandBus->dispatch(new CreatePostCommand(
            $this->id,
            $this->title,
            $this->slug,
            $this->content
        ));

        return $this->id;
    }
}
