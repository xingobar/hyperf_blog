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

use Hyperf\Contract\LengthAwarePaginatorInterface;

interface PostServiceInterface
{
    /**
     * 取得文章分頁資料.
     * @param int $limit - 每頁幾筆資料
     */
    public function findPaginator(array $params = [], int $limit = 10): LengthAwarePaginatorInterface;
}
