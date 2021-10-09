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

use Faker\Factory as FakerFactory;
use Hyperf\Database\Model\Factory;

class ModelFactory
{
    public function __invoke()
    {
        return Factory::construct(
            FakerFactory::create(),
            BASE_PATH . '/factories'
        );
    }
}
