<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterXdWorkroomBusiness extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('xd_workroom_business', function (Blueprint $table) {
            $table -> tinyInteger('page_display_mode')->default(0)->comment('患者端展示模式 0-标准模式 1-项目主题色+logo模式+不显示科室名称 2-项目主题色+logo模式+显示科室名称');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
