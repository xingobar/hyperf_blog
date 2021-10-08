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

class Post extends Model
{
    public const STATUS_DRAFT = 'DRAFT';

    public const STATUS_PUBLISH = 'PUBLISH';

    public const STATUS_OFFLINE = 'OFFLINE';

    public static $statusMap = [
        self::STATUS_PUBLISH => '發布',
        self::STATUS_DRAFT => '草稿',
        self::STATUS_OFFLINE => '下架',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'posts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'title', 'description', 'headline', 'image', 'image_filename',
        'status', 'price',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'price' => 'integer',
    ];

    /**
     * 作者.
     * @return \Hyperf\Database\Model\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
