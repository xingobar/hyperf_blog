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

use App\Request\AuthRequest;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\PostMapping;

/**
 * @Controller(prefix="auth")
 * Class AuthController
 */
class AuthController extends AbstractController
{
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

        return $this->response->json($params);
    }
}
