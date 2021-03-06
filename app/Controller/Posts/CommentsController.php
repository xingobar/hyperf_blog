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
namespace App\Controller\Posts;

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
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\PutMapping;

/**
 * @Controller(prefix="/posts/{postId}/comments")
 * Class CommentsController
 */
class CommentsController extends AbstractController
{
    /**
     * @Inject
     * @var PostServiceInterface
     */
    public $postService;

    /**
     * @Inject
     * @var CommentServiceInterface
     */
    public $commentService;

    /**
     * @GetMapping(path="")
     * @param int $postId - 文章編號
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function index(int $postId)
    {
        $limit = $this->request->input('limit', 10);

        if (! $post = $this->postService->findByIdWithPublished($postId)) {
            throw new NotFoundException();
        }

        $comments = $this->commentService->findPaginator(['post_id' => $postId], $limit);

        return (CommentResource::collection($comments))->toResponse();
    }

    /**
     * @Middleware(AuthenticateMiddleware::class)
     * @PostMapping(path="")
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function store(int $postId)
    {
        $request = $this->container->get(CommentRequest::class);
        $request->scene('create')->validateResolved();

        if (! $post = $this->postService->findByIdWithPublished($postId)) {
            throw new NotFoundException();
        }

        $params = $request->validated();

        // 新增父層留言
        $comment = $this->commentService->createComment(array_merge([
            'user_id' => auth()->user()->id,
            'post_id' => $postId,
            'parent_id' => null,
        ], $params));

        $comment->load([
            'owner',
        ]);

        return (new CommentResource($comment))->toResponse();
    }

    /**
     * @PutMapping(path="{commentId}")
     *
     * @Middleware(AuthenticateMiddleware::class)
     *
     * 更新留言
     * @param int $postId - 文章編號
     * @param int $commentId - 留言編號
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function update(int $postId, int $commentId)
    {
        $request = $this->container->get(CommentRequest::class);

        $request->scene('update')->validateResolved();

        if (! $post = $this->postService->findByIdWithPublished($postId)) {
            throw new NotFoundException();
        }

        if (! $comment = $post->parentComments()->find($commentId)) {
            throw new NotFoundException();
        }

        if (! policy($comment)->update(auth()->user(), $comment)) {
            throw new AccessDeniedException();
        }

        $params = $request->validated();

        $comment->update($params);

        return (new CommentResource($comment))->toResponse();
    }

    /**
     * @DeleteMapping(path="{commentId}")
     * @Middleware(AuthenticateMiddleware::class)
     *
     * @throws \Exception
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function delete(int $postId, int $commentId)
    {
        if (! $post = $this->postService->findByIdWithPublished($postId)) {
            throw new NotFoundException();
        }

        if (! $comment = $post->parentComments()->find($commentId)) {
            throw new NotFoundException();
        }

        if (! policy($comment)->delete(auth()->user(), $comment)) {
            throw new AccessDeniedException();
        }

        $comment->delete();

        return (new CommentResource($comment))->toResponse();
    }
}
