<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('menbers', function (Blueprint $table) {
            $table->id();

            $table->string("Name")->comment("姓名");
            $table->string("Password")->comment("密码");
            $table->integer("Permission")->comment("权限 0:成员， 1: 管理");
            $table->integer("Status")->comment("状态 0: 离开， 1: 在线");
            $table->unsignedInteger("LearnTime")->comment("学习时间");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menbers');
    }
};
