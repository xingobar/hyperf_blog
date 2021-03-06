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
namespace App\Controller;

use App\Contracts\Service\CategoryServiceInterface;
use App\Contracts\Service\PostServiceInterface;
use App\Exception\AccessDeniedException;
use App\Exception\NotFoundException;
use App\Middleware\AuthenticateMiddleware;
use App\Request\PostRequest;
use App\Resource\PostResource;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\DeleteMapping;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\PutMapping;

/**
 * @Controller(prefix="posts")
 * Class PostsController
 */
class PostsController extends AbstractController
{
    /**
     * 每頁 10 筆資料.
     */
    public const LIST_PAGE = 10;

    /**
     * @Inject
     * @var PostServiceInterface
     */
    public $postService;

    /**
     * @Inject
     * @var CategoryServiceInterface
     */
    public $categoryService;

    /**
     * @GetMapping(path="")
     */
    public function index()
    {
        $limit = $this->request->input('limit', self::LIST_PAGE);
        $params = $this->request->inputs(['keyword', 'price', 'category']);
        $posts = $this->postService->findPaginator($params, $limit);

        return PostResource::collection($posts)->toResponse();
    }

    /**
     * @GetMapping(path="{id}")
     *
     * @param int $id - 文章編號
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function show(int $id)
    {
        if (! $post = $this->postService->findByIdWithPublished($id)) {
            throw new NotFoundException();
        }

        $post->load([
            'owner',
            'category',
        ]);

        return (new PostResource($post))->toResponse();
    }

    /**
     * 更新文章.
     * @Middleware(AuthenticateMiddleware::class)
     * @PutMapping(path="{id}")
     *
     * @param int $id - 文章編號
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function update(int $id)
    {
        $request = $this->container->get(PostRequest::class);
        $request->scene('update')->validateResolved();

        if (! $post = $this->postService->findByIdWithPublished($id)) {
            throw new NotFoundException();
        }

        $params = $request->validated();

        if (! $category = $this->categoryService->findById($params['category_id'])) {
            throw new NotFoundException();
        }

        if (! $post->getPolicy()->update(auth()->user(), $post)) {
            throw new AccessDeniedException();
        }

        $post->update($params);

        $post->load([
            'category',
        ]);

        return (new PostResource($post))->toResponse();
    }

    /**
     * 刪除文章.
     * @Middleware(AuthenticateMiddleware::class)
     * @DeleteMapping(path="{id}")
     *
     * @param int $id - 文章編號
     * @throws \Exception
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function delete(int $id)
    {
        if (! $post = $this->postService->findByIdWithPublished($id)) {
            throw new NotFoundException();
        }

        if (! $post->getPolicy()->delete(auth()->user(), $post)) {
            throw new AccessDeniedException();
        }

        $post->delete();

        return (new PostResource($post))->getResponse();
    }

    /**
     * @PostMapping(path="")
     * @Middleware(AuthenticateMiddleware::class)
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function store()
    {
        $request = $this->container->get(PostRequest::class);
        $request->scene('create')->validateResolved();

        $params = $request->validated();

        if (! $category = $this->categoryService->findById($params['category_id'])) {
            throw new NotFoundException();
        }

        $post = $this->postService->createPost(array_merge([
            'user_id' => auth()->user()->id,
        ], $params));

        $post->load(['category']);

        return (new PostResource($post))->toResponse();
    }
}
