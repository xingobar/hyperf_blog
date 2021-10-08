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
use App\Exception\NotFoundException;
use App\Mail\ConfirmEmail;
use App\Request\AuthRequest;
use App\Request\VerifyEmailRequest;
use App\Resource\UserResource;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\Utils\Str;
use HyperfExt\Mail\Mail;

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

        // 取得參數
        $params = $authRequest->inputs(['account', 'email', 'password']);

        $user = $this->userService->createUser(array_merge($params, [
            'confirm_token' => Str::random(32),
        ]));

        // 寄送信箱驗證信件
        Mail::to($user->email)->queue(new ConfirmEmail());

        return (new UserResource($user))->toResponse();
    }

    /**
     * 信箱驗證會員
     * @PostMapping(path="verify")
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function verify(VerifyEmailRequest $request)
    {
        $params = $request->inputs(['token']);

        if (! $user = $this->userService->findByConfirmToken($params['token'])) {
            throw new NotFoundException();
        }

        $user->update([
            'confirm_token' => null,
            'verified' => true,
            'verifed_at' => time(),
        ]);

        return (new UserResource($user))->toResponse();
    }
}
