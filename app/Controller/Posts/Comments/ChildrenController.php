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
use App\Exception\AccessDeniedException;
use App\Exception\NotFoundException;
use App\Middleware\AuthenticateMiddleware;
use App\Request\CommentRequest;
use App\Resource\CommentResource;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\DeleteMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\PutMapping;

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

    /**
     * @PutMapping(path="{childrenId}")
     * @Middleware(AuthenticateMiddleware::class)
     *
     * @param int $postId - 文章編號
     * @param int $parentId - 父層留言編號
     * @param int $childrenId - 子留言編號
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function update(int $postId, int $parentId, int $childrenId)
    {
        $request = $this->container->get(CommentRequest::class);
        $request->scene('update');

        $request->validateResolved();

        $params = $request->validated();

        if (! $post = $this->postService->findByIdWithPublished($postId)) {
            throw new NotFoundException();
        }

        if (! $parent = $post->parentComments()->find($parentId)) {
            throw new NotFoundException();
        }

        if (! $children = $parent->children()->find($childrenId)) {
            throw new NotFoundException();
        }

        if (! policy($children)->update(auth()->user(), $children)) {
            throw new AccessDeniedException();
        }

        $children->update($params);

        return (new CommentResource($children))->toResponse();
    }

    /**
     * @DeleteMapping(path="{childrenId}")
     * @Middleware(AuthenticateMiddleware::class)
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function delete(int $postId, int $parentId, int $childrenId)
    {
        if (! $post = $this->postService->findByIdWithPublished($postId)) {
            throw new NotFoundException();
        }

        if (! $parent = $post->parentComments()->find($parentId)) {
            throw new NotFoundException();
        }

        if (! $children = $parent->children()->find($childrenId)) {
            throw new NotFoundException();
        }

        if (! policy($children)->delete(auth()->user(), $children)) {
            throw new AccessDeniedException();
        }

        $children->delete();

        return (new CommentResource($children))->toResponse();
    }
}
