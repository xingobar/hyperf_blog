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

use App\Contracts\Service\UserServiceInterface;
use App\Model\User;
use App\Repository\UserRepository;
use Hyperf\Di\Annotation\Inject;
use HyperfExt\Hashing\Hash;

class UserService implements UserServiceInterface
{
    /**
     * @Inject
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * 新增會員
     * @return \App\Model\User|\Hyperf\Database\Model\Model
     */
    public function createUser(array $params): User
    {
        return $this->userRepository->create($params);
    }

    /**
     * 根據 confirm token 取得會員
     */
    public function findByConfirmToken(string $confirmToken): ?User
    {
        return $this->userRepository->findByConfirmToken($confirmToken);
    }

    /**
     * 根據帳號取得會員
     */
    public function findByAccount(string $account): ?User
    {
        return $this->userRepository->findByAccount($account);
    }

    /**
     * 檢查密碼是否一致.
     */
    public function checkSamePassword(User $user, string $password): bool
    {
        return Hash::check($password, strval($user->password));
    }
}
