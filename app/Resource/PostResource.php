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
namespace App\Resource;

use Hyperf\Resource\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(): array
    {
        return [
            'id' => intval($this->id),
            'title' => strval($this->title),
            'headline' => strval($this->headline),
            'description' => strval($this->description),
            'image' => strval($this->image),
            'image_filename' => strval($this->image_filename),
            'status' => strval($this->status),
            'price' => intval($this->price),
            'created_at' => strval($this->created_at),
            'updated_at' => strval($this->updated_at),

            // 文章創建者
            'owner' => $this->when($this->relationLoaded('owner'), function () {
                return new UserResource($this->owner);
            }),

            // 文章分類
            'category' => $this->when($this->relationLoaded('category'), function () {
                return new CategoryResource($this->category);
            }),
        ];
    }
}
