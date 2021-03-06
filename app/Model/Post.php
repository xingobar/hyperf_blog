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

use App\Policy\PostPolicy;
use App\Repository\PostRepository;
use Hyperf\Database\Model\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    public const STATUS_DRAFT = 'DRAFT';

    public const STATUS_PUBLISH = 'PUBLISH';

    public const STATUS_OFFLINE = 'OFFLINE';

    public static $statusMap = [
        self::STATUS_PUBLISH => '發布',
        self::STATUS_DRAFT => '草稿',
        self::STATUS_OFFLINE => '下架',
    ];

    protected $policy = PostPolicy::class;

    protected $repository = PostRepository::class;

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
        'status', 'price', 'category_id',
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

    /**
     * 文章分類.
     * @return \Hyperf\Database\Model\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    /**
     * 留言資料.
     * @return \Hyperf\Database\Model\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }

    /**
     * 父層留言
     * @return \Hyperf\Database\Model\Relations\HasMany
     */
    public function parentComments()
    {
        return $this->hasMany(Comment::class, 'post_id', 'id')
            ->whereNull('parent_id');
    }
}
