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

use App\Model\Category;
use Hyperf\Utils\Collection;

interface CategoryServiceInterface
{
    /**
     * 取得分類列表.
     */
    public function findList(): Collection;

    /**
     * 根據編號取得分類.
     */
    public function findById(int $categoryId): ?Category;
}
