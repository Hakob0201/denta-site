<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleViewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_views', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('article_id')->unsigned();
            $table->char('locale')->index();
            $table->integer('views')->index();

            $table->unique(['article_id', 'locale']);
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article_views');
    }
}
