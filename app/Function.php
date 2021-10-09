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
if (! function_exists('auth')) {
/**
 * Auth认证辅助方法.
 *
 * @param null|string $guard 守护名称
 *
 * @return \HyperfExt\Auth\Contracts\GuardInterface|\HyperfExt\Auth\Contracts\StatefulGuardInterface|\HyperfExt\Auth\Contracts\StatelessGuardInterface
 */ function auth(string $guard = 'api')
    {
        if (is_null($guard)) {
            $guard = config('auth.default.guard');
        }

        return make(\HyperfExt\Auth\Contracts\AuthManagerInterface::class)->guard($guard);
    }
}

/*
 * 取得現在時間
 */
if (! function_exists('now')) {
    function now($tz = null)
    {
        return \Carbon\Carbon::now($tz);
    }
}

// factory
if (! function_exists('factory')) {
    /**
     * @return \Hyperf\Database\Model\FactoryBuilder
     */
    function factory()
    {
        $factory = make(\Hyperf\Database\Model\Factory::class);

        $arguments = func_get_args();

        if (isset($arguments[1]) && is_string($arguments[1])) {
            return $factory->of($arguments[0], $arguments[1])->times($arguments[2] ?? null);
        }
        if (isset($arguments[1])) {
            return $factory->of($arguments[0])->times($arguments[1]);
        }

        return $factory->of($arguments[0]);
    }
}
