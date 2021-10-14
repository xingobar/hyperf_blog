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

use App\Contracts\Service\UserServiceInterface;
use App\Mail\VerifyEmail;
use App\Middleware\AuthenticateMiddleware;
use App\Middleware\VerifyJwtTokenMiddleware;
use App\Request\UpdateUserRequest;
use App\Resource\UserResource;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use Hyperf\HttpServer\Annotation\PutMapping;
use Hyperf\Utils\Str;
use HyperfExt\Hashing\Hash;
use HyperfExt\Mail\Mail;

/**
 * @Controller(prefix="me")
 * Class MeController
 */
class MeController extends AbstractController
{
    /**
     * @Inject
     * @var UserServiceInterface
     */
    public $userService;

    /**
     * @Middlewares({
     *     @Middleware(VerifyJwtTokenMiddleware::class),
     *     @Middleware(AuthenticateMiddleware::class)
     * })
     * @PutMapping(path="")
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function update(UpdateUserRequest $request)
    {
        // 取得過濾過的資料
        $params = $request->validated();

        // 因為更改信箱, 所以要重新驗證
        if (isset($params['email'])) {
            // 寄送信箱驗證信件
            Mail::to($params['email'])->queue(new VerifyEmail());
            auth()->user()->update([
                'confirm_token' => Str::random(32),
            ]);
        }

        // 密碼重新加密
        if (isset($params['password'])) {
            $params['password'] = Hash::make($params['password']);
        }

        auth()->user()->fill($params)->save();

        return (new UserResource(auth()->user()))->toResponse();
    }
}
