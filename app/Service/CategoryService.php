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

use App\Contracts\Service\CategoryServiceInterface;
use App\Model\Category;
use App\Repository\CategoryRepository;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Utils\Collection;

class CategoryService implements CategoryServiceInterface
{
    /**
     * @Inject
     * @var CategoryRepository
     */
    public $categoryRepository;

    /**
     * 取得多筆分類資料.
     */
    public function findList(): Collection
    {
        return $this->categoryRepository->findList();
    }

    /**
     * 根據編號取得分類.
     * @return null|Category|Category[]|\Hyperf\Database\Model\Collection|\Hyperf\Database\Model\Model
     */
    public function findById(int $categoryId): ?Category
    {
        return $this->categoryRepository->findById($categoryId);
    }
}
