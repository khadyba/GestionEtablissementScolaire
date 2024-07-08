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
        Schema::create('eleves_cours', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cour_id');
            $table->unsignedBigInteger('eleve_id');
            $table->unsignedBigInteger('salle_de_classe_id')->nullable();

            
            $table->foreign('salle_de_classe_id')->references('id')->on('salle_de_classes')->onDelete('cascade');
            $table->foreign('cour_id')->references('id')->on('cours')->onDelete('cascade');
            $table->foreign('eleve_id')->references('id')->on('eleves')->onDelete('cascade');
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
        Schema::dropIfExists('eleves_cours');
    }
};
