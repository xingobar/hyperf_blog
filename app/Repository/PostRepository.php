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
     * 取得文章分頁資料.
     * @param int $limit - 每頁幾筆資料
     * @return \Hyperf\Contract\LengthAwarePaginatorInterface
     */
    public function findPaginator(array $params = [], int $limit = 10)
    {
        return Post::orderBy('created_at', 'DESC')
            ->with([
                'owner',
                'category',
            ])
            // 關鍵字
            ->when(isset($params['keyword']), function ($builder) use ($params) {
                $builder->where(function ($builder) use ($params) {
                    $keyword = sprintf('%%%s%%', $params['keyword']);
                    $builder->where('title', 'like', $keyword)
                        ->orWhere('headline', 'like', $keyword)
                        ->orWhere('description', 'like', $keyword);
                });
            })
            // 分類
            ->when(isset($params['category']), function ($builder) use ($params) {
                $builder->where('category_id', $params['category']);
            })
            // 文章狀態
            ->when(isset($params['status']) && in_array($params['status'], array_keys(Post::$statusMap)), function ($builder) use ($params) {
                $builder->where('status', $params['status']);
            }, function ($builder) {
                // 預設取得發佈的文章
                $builder->where('status', Post::STATUS_PUBLISH);
            })
            // 是否取得免費
            ->when(isset($params['is_free']) && is_bool($params['is_free']), function ($builder) use ($params) {
                if ($params['is_free']) {
                    $builder->where('price', 0);
                } else {
                    $builder->where('price', '>', 0);
                }
            })
            ->paginate($limit);
    }

    /**
     * 根據編號取得文章.
     *
     * @return null|\Hyperf\Database\Model\Builder|\Hyperf\Database\Model\Model|object
     */
    public function findByIdWithPublished(int $postId): ?Post
    {
        return Post::where('id', $postId)
            ->where('status', Post::STATUS_PUBLISH)
            ->first();
    }
}
