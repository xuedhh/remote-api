<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkroomExternalUserConfig extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workroom_external_user_config', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mates_id', 11)->default('')->comment('xd_workroom_mates表的ID');
            $table->tinyInteger('online_consult_show')->default(0)->comment('在线咨询展示 0-不展示 1-展示');
            $table->tinyInteger('dept_page_show')->default(0)->comment('科室主页展示 0-不展示 1-展示');
            $table->datetime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('创建时间');
            $table->datetime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'))->comment('更新时间');
            // 设置索引
            $table->index('mates_id','matesId');
        });
        // 添加表注释
        DB::statement('ALTER TABLE workroom_external_user_config COMMENT "workroom扩展用户表"');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('workroom_external_user_config');
    }
}
