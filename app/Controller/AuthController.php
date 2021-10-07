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
namespace App\Controller;

use App\Contracts\UserServiceInterface;
use App\Request\AuthRequest;
use App\Resource\UserResource;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\Utils\Str;

/**
 * @Controller(prefix="auth")
 * Class AuthController
 */
class AuthController extends AbstractController
{
    /**
     * @Inject
     * @var UserServiceInterface
     */
    public $userService;

    /**
     * @PostMapping(path="register")
     * 註冊
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function register()
    {
        // 使用登入的 scene
        $authRequest = $this->container->get(AuthRequest::class);
        $authRequest->scene('register')->validateResolved();

        $params = $authRequest->inputs(['account', 'email', 'password']);

        $user = $this->userService->createUser(array_merge($params, [
            'confirm_token' => Str::random(32),
        ]));

        return (new UserResource($user))->toResponse();
    }
}
