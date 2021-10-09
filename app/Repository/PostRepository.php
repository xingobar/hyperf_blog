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
namespace App\Repository;

use App\Model\Post;

class PostRepository
{
    /**
     * 文章分頁
     * @param int $limit - 每頁幾筆資料
     * @return \Hyperf\Contract\LengthAwarePaginatorInterface
     */
    public function findPaginator(int $limit = 10)
    {
        return Post::orderBy('created_at', 'DESC')
            ->paginate($limit);
    }
}
