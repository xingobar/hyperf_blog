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
namespace App\Contracts;

use App\Model\Post;
use Hyperf\Contract\LengthAwarePaginatorInterface;

interface PostServiceInterface
{
    /*
     * 取得文章分頁資料.
     *
     * @param array $params - 參數資訊
     * @param int $limit - 每頁幾筆資料
     * @return LengthAwarePaginatorInterface
     */
    public function findPaginator(array $params = [], int $limit = 10): LengthAwarePaginatorInterface;

    /**
     * 根據編號取得發佈的文章.
     *
     * @param int $postId - 文章編號
     * @return mixed
     */
    public function findByIdWithPublished(int $postId): ?Post;

    /**
     * 新增文章.
     */
    public function createPost(array $params): Post;
}
