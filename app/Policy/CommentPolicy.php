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
namespace App\Policy;

use App\Model\Comment;
use App\Model\User;
use HyperfExt\Auth\Access\HandlesAuthorization;
use HyperfExt\Auth\Annotations\Policy;

/**
 * @Policy({Comment::class})
 */
class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @return bool|\HyperfExt\Auth\Access\Response
     */
    public function viewAny(User $user)
    {
    }

    /**
     * Determine whether the user can view the model.
     *
     * @return bool|\HyperfExt\Auth\Access\Response
     */
    public function view(User $user, Comment $comment)
    {
    }

    /**
     * Determine whether the user can create models.
     *
     * @return bool|\HyperfExt\Auth\Access\Response
     */
    public function create(User $user)
    {
    }

    /**
     * Determine whether the user can update the model.
     *
     * @return bool|\HyperfExt\Auth\Access\Response
     */
    public function update(User $user, Comment $comment)
    {
        return $user->id === $comment->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return bool|\HyperfExt\Auth\Access\Response
     */
    public function delete(User $user, Comment $comment)
    {
        return $user->id === $comment->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @return bool|\HyperfExt\Auth\Access\Response
     */
    public function restore(User $user, Comment $comment)
    {
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @return bool|\HyperfExt\Auth\Access\Response
     */
    public function forceDelete(User $user, Comment $comment)
    {
    }
}
