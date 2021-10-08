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

use App\Model\User;
use HyperfExt\Hashing\Hash;

class UserRepository
{
    /**
     * 新增會員
     *
     * @return \Hyperf\Database\Model\Model|User
     */
    public function create(array $params): User
    {
        return User::create(array_merge($params, [
            'password' => Hash::make($params['password']),
        ]));
    }

    /**
     * 根據 confirm token 取得會員
     * @return null|\Hyperf\Database\Model\Builder|\Hyperf\Database\Model\Model|object
     */
    public function findByConfirmToken(string $token): ?User
    {
        return User::where('confirm_token', $token)
            ->first();
    }
}
