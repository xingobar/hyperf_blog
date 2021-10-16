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

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(): array
    {
        return [
            'id' => intval($this->id),
            'title' => strval($this->title),
            'body' => strval($this->body),
            'owner' => new UserResource($this->whenLoaded('owner')),
            'created_at' => strval($this->created_at),
            'updated_at' => strval($this->updated_at),
        ];
    }
}
