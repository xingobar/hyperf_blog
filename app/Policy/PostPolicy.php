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

use App\Model\Post;
use HyperfExt\Auth\Annotations\Policy;
use HyperfExt\Auth\Contracts\AuthenticatableInterface;

/**
 * @Policy(models="Post")
 * Class PostPolicy
 */
class PostPolicy
{
    public function update(?AuthenticatableInterface $user, Post $post)
    {
        return $user->id === $post->user_id;
    }

    public function delete(?AuthenticatableInterface $user, Post $post)
    {
        return $this->update($user, $post);
    }
}
