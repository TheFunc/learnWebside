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
        Schema::create('external_infos', function (Blueprint $table) {
            $table->id();

            $table->string("type")->comment("外部类型");
            $table->string("name")->comment("外部名称");
            $table->string("url")->comment("外部链接");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('external_infos');
    }
};
