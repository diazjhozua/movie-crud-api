<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('genre_id')->unsigned()->nullable();
            $table->unsignedBigInteger('certificate_id')->unsigned()->nullable();
            $table->string('title');
            $table->string('studio');
            $table->string('duration');
            $table->text('background')->default('');
            $table->string('saga');
            $table->string('picture')->default('');
            $table->timestamps();

            $table->foreign('genre_id')->references('id')
                ->on('genres')->onDelete('set null');

            $table->foreign('certificate_id')->references('id')
                ->on('certificates')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('movies');
    }
}
