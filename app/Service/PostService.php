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
namespace App\Service;

use App\Contracts\PostServiceInterface;
use App\Model\Post;
use App\Repository\PostRepository;
use Hyperf\Contract\LengthAwarePaginatorInterface;
use Hyperf\Di\Annotation\Inject;

class PostService implements PostServiceInterface
{
    /**
     * @Inject
     * @var PostRepository
     */
    public $postRepository;

    public function findPaginator(array $params = [], int $limit = 10): LengthAwarePaginatorInterface
    {
        return $this->postRepository->findPaginator($params, $limit);
    }

    /**
     * @param int $postId - 文章編號
     * @return null|\Hyperf\Database\Model\Builder|\Hyperf\Database\Model\Model|object|Post
     */
    public function findByIdWithPublished(int $postId): ?Post
    {
        return $this->postRepository->findByIdWithPublished($postId);
    }
}
