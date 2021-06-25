<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_contents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('article_id');
            $table->char('locale', 2)->index();
            $table->string('title', 255);
            $table->string('anons', 512);
            $table->longText('text');
            $table->string('video', 512)->nullable();
            $table->unsignedBigInteger('audio_id')->nullable();
            $table->boolean('live')->default(0);
            $table->boolean('marked')->default(0);
            $table->boolean('comment')->default(0);
            $table->date('date_at')->index();
            $table->timeTz('time_at')->index();
            $table->dateTimeTz('datetime_at')->index();
            $table->boolean('onoff')->default(0)->index();
            $table->timestamps();

            $table->unique(['article_id', 'locale']);
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
            $table->foreign('audio_id')->references('id')->on('audios')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article_contents');
    }
}
