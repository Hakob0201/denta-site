<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->char('locale', 2)->index();
            $table->char('content_type', 32);
            $table->string('path')->index();
            $table->string('title');
            $table->longText('body');
            $table->string('meta_title', 100)->nullable();
            $table->string('meta_desc', 160)->nullable();
            $table->string('meta_keywords')->nullable();
            $table->boolean('onoff')->default(1)->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
    }
}
