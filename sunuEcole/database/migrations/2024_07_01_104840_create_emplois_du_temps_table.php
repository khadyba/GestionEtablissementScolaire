<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emplois_du_temps', function (Blueprint $table) {
            $table->id();
            $table->string('emplois_du_temps');
            $table->string('nom_original');
            $table->unsignedBigInteger('administrateur_id');
            $table->unsignedBigInteger('classe_id');
            $table->foreign('administrateur_id')->references('id')->on('administrateurs')->onDelete('cascade');
            $table->foreign('classe_id')->references('id')->on('classes')->onDelete('cascade');

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
        Schema::dropIfExists('emplois_du_temps');
    }
};
