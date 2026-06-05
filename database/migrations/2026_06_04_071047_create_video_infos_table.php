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
        Schema::create('video_infos', function (Blueprint $table) {
            $table->id();

            $table->string("title")->comment("视频标题");
            $table->integer("GroupID")->comment("视频组ID");
            $table->integer("TypeID")->comment("视频类型ID");
            $table->string("Path")->comment("视频路径");
            $table->string("Description")->comment("视频描述");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('video_infos');
    }
};
