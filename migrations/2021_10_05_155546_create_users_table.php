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

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('account')->comment('帳號');
            $table->string('avatar')->nullable()->comment('頭像');
            $table->string('email')->comment('信箱');
            $table->string('password')->comment('密碼');
            $table->string('gender')->default(\App\Model\User::GENDER_MALE)->comment('性別');
            $table->boolean('verified')->default(0)->comment('驗證狀態')->index();
            $table->string('confirm_token')->nullable()->comment('驗證信箱的 token');
            $table->timestamp('verified_at')->nullable()->comment('驗證時間');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
}
