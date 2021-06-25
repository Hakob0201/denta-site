<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('zone_id');
            $table->string('type', 32);
            $table->string('title', 64);
            $table->string('file', 128)->nullable();
            $table->string('filemobile', 128)->nullable();
            $table->text('code')->nullable();
            $table->text('codemobile')->nullable();
            $table->string('link', 255)->nullable();
            $table->string('linkmobile', 255)->nullable();
            $table->string('width', 12);
            $table->string('height', 12);
            $table->integer('views')->index()->nullable();
            $table->integer('views_total')->index()->nullable();
            $table->integer('rotation')->index();
            $table->date('start_at')->index()->nullable();
            $table->date('end_at')->index()->nullable();
            $table->boolean('onoff')->default(0)->index();
            $table->timestamps();

            $table->foreign('zone_id')->references('id')->on('banners_zones')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banners');
    }
}
