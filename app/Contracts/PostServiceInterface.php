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
     * @return array
     */
    public function findPaginator(int $limit = 10): LengthAwarePaginatorInterface;
}
