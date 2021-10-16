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

use App\Model\Comment;

class CommentRepository
{
    public function create(array $params): Comment
    {
        return Comment::create($params);
    }

    public function findByPaginator(array $params = [], int $limit = 10)
    {
        return Comment::with([
            'children',
        ])
            ->when(isset($params['post_id']), function ($builder) use ($params) {
                $builder->where('post_id', $params['post_id']);
            })
            ->whereNull('parent_id')
            ->orderByDesc('created_at')
            ->paginate($limit);
    }
}
