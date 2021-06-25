<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleImageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_image', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('article_id');
            $table->unsignedBigInteger('image_id');
            $table->smallInteger('main')->index()->default(0);
            $table->smallInteger('ordering')->index()->default(99);
            $table->smallInteger('slider')->index()->default(0);
            $table->boolean('show_title')->default(0);

            $table->unique(['article_id', 'image_id']);
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
            $table->foreign('image_id')->references('id')->on('images')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article_image');
    }
}
