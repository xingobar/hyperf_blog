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
namespace App\Request;

use Hyperf\Validation\Request\FormRequest;

class PostRequest extends FormRequest
{
    public $scenes = [
        'update' => [
            'title', 'headline', 'description',
            'image', 'image_filename', 'price',
            'category_id',
        ],
        'create' => [
            'title', 'headline', 'description',
            'image', 'image_filename', 'price',
            'category_id',
        ],
    ];

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        if ($this->getScene() === 'update') {
            return $this->getUpdateRule();
        }

        return [
            'title' => 'required|max:150',
            'headline' => 'present|max:150',
            'description' => 'required|max:150',
            'image' => 'required',
            'image_filename' => 'required',
            'price' => 'required|integer|min:0',
            'category_id' => 'required|integer',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => '請輸入文章標題',
            'title.max' => '標題最大字數為 :max 個字',
            'headline.present' => '請輸入副標題',
            'headline.max' => '副標題最大字數為 :max 個字',
            'description.required' => '請傳入說明的文字',
            'description.max' => '說明最大字數為 :max 個字',
            'image.required' => '請傳入圖片',
            'image_filename.required' => '請傳入圖片檔案名稱',
            'price.required' => '請傳入文章價格',
            'price.integer' => '價格型別有誤',
            'price.min' => '價格至少 :min 元',
            'category_id.required' => '請傳入分類編號',
            'category_id.integer' => '分類編號型別有誤',
        ];
    }

    private function getUpdateRule()
    {
        $rules = [];
        if ($this->has('title')) {
            $rules['title'] = 'required|max:150';
        }

        if ($this->has('headline')) {
            $rules['headline'] = 'required|max:150';
        }

        if ($this->has('description')) {
            $rules['description'] = 'required|max:150';
        }

        if ($this->has('image')) {
            $rules['image'] = 'required';
        }

        if ($this->has('image_filename')) {
            $rules['image_filename'] = 'required';
        }

        if ($this->has('price')) {
            $rules['price'] = 'required|integer|min:0';
        }

        if ($this->has('category_id')) {
            $rules['category_id'] = 'required|integer';
        }

        return $rules;
    }
}
