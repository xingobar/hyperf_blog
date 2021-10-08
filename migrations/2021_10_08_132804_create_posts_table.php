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
use Hyperf\Database\Migrations\Migration;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Schema\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index()->comment('會員編號');
            $table->foreign('user_id')->on('users')->references('id');
            $table->text('title')->nullable()->comment('文章標題');
            $table->text('description')->nullable()->comment('文章內容');
            $table->text('headline')->nullable()->comment('文章副標題');
            $table->string('image')->nullable()->comment('文章圖片');
            $table->string('image_filename')->nullable()->comment('圖片檔名');
            $table->string('status')->default(\App\Model\Post::STATUS_DRAFT)->comment('狀態')->index();
            $table->integer('price')->default(0)->comment('價錢');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
}
