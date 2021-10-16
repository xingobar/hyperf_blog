<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace App\Controller\Posts\Comments;

use App\Contracts\Service\CommentServiceInterface;
use App\Contracts\Service\PostServiceInterface;
use App\Controller\AbstractController;
use App\Exception\NotFoundException;
use App\Middleware\AuthenticateMiddleware;
use App\Request\CommentRequest;
use App\Resource\CommentResource;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\PostMapping;

/**
 * @Controller(prefix="/posts/{postId}/comments/{parentId}/children")
 * Class ChildrenController
 */
class ChildrenController extends AbstractController
{
    /**
     * @Inject
     * @var CommentServiceInterface
     */
    public $commentService;

    /**
     * @Inject
     * @var PostServiceInterface
     */
    public $postService;

    /**
     * @PostMapping(path="")
     * @Middleware(AuthenticateMiddleware::class)
     *
     * @param int $postId - 文章編號
     * @param int $parentId - 父層留言編號
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function store(int $postId, int $parentId)
    {
        $request = $this->container->get(CommentRequest::class);
        $request->scene('create')->validateResolved();

        if (! $post = $this->postService->findByIdWithPublished($postId)) {
            throw new NotFoundException();
        }

        if (! $parent = $post->parentComments()->find($parentId)) {
            throw new NotFoundException();
        }

        $params = $request->validated();

        $children = $this->commentService->createComment(array_merge([
            'user_id' => auth()->user()->id,
            'parent_id' => $parentId,
            'post_id' => $postId,
        ], $params));

        return (new CommentResource($children))->toResponse();
    }
}
