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
        Schema::create('homework_mens', function (Blueprint $table) {
            $table->id();

            $table->string("Name")->comment("提交成员姓名");
            $table->string("Title")->comment("提交作业的标题");
            $table->string("Path")->comment("提交作业的路径");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('homework_mens');
    }
};
