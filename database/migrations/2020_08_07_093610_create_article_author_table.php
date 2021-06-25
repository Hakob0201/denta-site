<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleAuthorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_author', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('article_id')->unsigned();
            $table->unsignedBigInteger('author_id')->unsigned();

            $table->unique(['article_id', 'author_id']);
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
            $table->foreign('author_id')->references('id')->on('authors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article_author');
    }
}
