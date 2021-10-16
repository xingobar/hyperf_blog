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

use App\Contracts\Service\CommentServiceInterface;
use App\Model\Comment;
use App\Repository\CommentRepository;
use Hyperf\Contract\LengthAwarePaginatorInterface;
use Hyperf\Di\Annotation\Inject;

class CommentService implements CommentServiceInterface
{
    /**
     * @Inject
     * @var CommentRepository
     */
    protected $commentRepository;

    public function createComment(array $params): Comment
    {
        return $this->commentRepository->create($params);
    }

    public function findPaginator(array $params = [], int $limit = 10): LengthAwarePaginatorInterface
    {
        return $this->commentRepository->findByPaginator($params, $limit);
    }
}
