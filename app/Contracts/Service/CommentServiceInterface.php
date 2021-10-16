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

interface CommentServiceInterface
{
    /**
     * 新增評價.
     */
    public function createComment(array $params): Comment;
}
