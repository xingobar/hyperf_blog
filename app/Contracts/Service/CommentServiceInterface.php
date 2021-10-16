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
namespace App\Contracts\Service;

use App\Model\Comment;
use Hyperf\Contract\LengthAwarePaginatorInterface;

interface CommentServiceInterface
{
    /**
     * 新增評價.
     *
     * @param array $params - 參數
     */
    public function createComment(array $params): Comment;

    /**
     * 取得評論分頁
     */
    public function findPaginator(array $params = [], int $limit = 10): LengthAwarePaginatorInterface;
}
