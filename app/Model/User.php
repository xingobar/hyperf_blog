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
use HyperfExt\Auth\Authenticatable;
use HyperfExt\Auth\Contracts\AuthenticatableInterface;
use HyperfExt\Jwt\Contracts\JwtSubjectInterface;

class User extends Model implements AuthenticatableInterface, JwtSubjectInterface
{
    use SoftDeletes;
    use Authenticatable;

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

    public function getJwtIdentifier()
    {
        return $this->getKey();
    }

    /**
     * JWT自定義載荷.
     */
    public function getJwtCustomClaims(): array
    {
        return [
            'guard' => 'api',    // 新增一個自定義載荷儲存守護名稱，方便後續判斷
        ];
    }

    /**
     * 文章.
     * @return \Hyperf\Database\Model\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id', 'id');
    }
}
