<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilmActorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('film_actors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('movie_id')->unsigned();
            $table->unsignedBigInteger('actor_id')->unsigned();
            $table->unsignedBigInteger('role_id')->unsigned()->nullable();
            $table->string('name');
            $table->text('description')->default('');
            $table->timestamps();

            $table->foreign('movie_id')->references('id')
                ->on('movies')->onDelete('cascade');

            $table->foreign('actor_id')->references('id')
                ->on('actors')->onDelete('cascade');

            $table->foreign('role_id')->references('id')
                ->on('roles')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('film_actors');
    }
}
