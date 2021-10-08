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
namespace App\Model;

use Hyperf\Database\Model\SoftDeletes;
use Qbhy\HyperfAuth\Authenticatable;

class User extends Model implements Authenticatable
{
    use SoftDeletes;

    public const GENDER_MALE = 'MALE';

    public const GENDER_FEMALE = 'FEMALE';

    public static $genderMap = [
        self::GENDER_FEMALE => '女性',
        self::GENDER_MALE => '男性',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'account', 'email', 'avatar', 'password', 'gender', 'verified_at', 'confirm_token', 'verified',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'verified' => 'boolean',
    ];

    public function getId()
    {
        // TODO: Implement getId() method.
    }

    public static function retrieveById($key): ?Authenticatable
    {
        // TODO: Implement retrieveById() method.
    }
}
