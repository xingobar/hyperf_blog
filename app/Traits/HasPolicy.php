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
namespace App\Traits;

trait HasPolicy
{
    protected $policy;

    public function getPolicy()
    {
        if (! $this->policy || ! class_exists($this->policy)) {
            throw new \RuntimeException(sprintf('找不到 %s policy', static::class));
        }

        return $this->getContainer()->get($this->policy);
    }
}
