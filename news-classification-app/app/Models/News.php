<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->unsignedBigInteger('category_level_1');
            $table->unsignedBigInteger('category_level_2');
            $table->timestamps();

            // กำหนด foreign key
            $table->foreign('category_level_1')->references('id')->on('categories');
            $table->foreign('category_level_2')->references('id')->on('categories');
        });
    }

    public function down()
    {
        Schema::dropIfExists('news');
    }
}
