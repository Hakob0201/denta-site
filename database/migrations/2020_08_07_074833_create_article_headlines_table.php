<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleHeadlinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_headlines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('article_id');
            $table->unsignedBigInteger('layout_id');
            $table->char('locale', 2)->index();
            $table->char('category_key', 64)->index();
            $table->string('title')->nullable();
            $table->string('anons', 250)->nullable();
            $table->unsignedBigInteger('ordering')->index()->default(0);
            $table->dateTimeTz('datetime_at')->index();
            $table->timestamps();
            $table->unique(['article_id', 'locale', 'category_key']);
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
        Schema::dropIfExists('article_headlines');
    }
}
