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

use App\Model\User;

interface UserServiceInterface
{
    /**
     * 新增會員
     */
    public function createUser(array $params): User;

    /**
     * 根據 confirm token 取得會員
     */
    public function findByConfirmToken(string $confirmToken): ?User;

    /**
     * 根據帳號取得會員
     */
    public function findByAccount(string $account): ?User;

    /**
     * 檢查密碼是否一致.
     */
    public function checkSamePassword(User $user, string $password): bool;
}
