<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilmProducersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('film_producers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('producer_id')->nullable();
            $table->unsignedBigInteger('movie_id')->nullable();
            $table->string('type');
            $table->timestamps();

            $table->foreign('producer_id')->references('id')
                ->on('producers')->onDelete('cascade');
                
            $table->foreign('movie_id')->references('id')
                ->on('movies')->onDelete('cascade');
        });
    }   

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('film_producers');
    }
}
