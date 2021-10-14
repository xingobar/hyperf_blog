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

use App\Model\Category;

class CategoryRepository
{
    /**
     * 取得分類列表.
     * @return \Hyperf\Utils\Collection
     */
    public function findList()
    {
        return Category::orderByDesc('created_at')
            ->get();
    }

    /**
     * 根據編號取得分類資料.
     * @return null|Category|Category[]|\Hyperf\Database\Model\Collection|\Hyperf\Database\Model\Model
     */
    public function findById(int $categoryId): ?Category
    {
        return Category::find($categoryId);
    }
}
