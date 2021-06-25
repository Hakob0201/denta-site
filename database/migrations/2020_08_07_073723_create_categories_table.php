<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('layout_id')->nullable();
            $table->string('category_key', 64)->unique();
            $table->string('category_name', 512);
            $table->enum('category_type', ['article', 'economic'])->default('article');
            $table->boolean('visible')->default(1);
            $table->boolean('headline_visible')->default(0);
            $table->smallInteger('headline_position')->index()->default(0);
            $table->smallInteger('ordering')->index()->default(0);
            $table->boolean('onoff')->default(1);
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            $table->foreign('layout_id')->references('id')->on('layouts')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
