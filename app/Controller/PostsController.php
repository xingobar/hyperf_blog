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

use App\Resource\PostResource;
use App\Service\PostService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;

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
     * @var PostService
     */
    public $postService;

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
}
