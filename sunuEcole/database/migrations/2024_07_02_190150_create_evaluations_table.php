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
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->string('type');
            $table->date('jours');
            $table->time('heure_debut');
            $table->time('heure_fin'); 
            $table->boolean('is_annuler')->default(false);
            $table->unsignedBigInteger('professeur_id');
            $table->foreign('professeur_id')->references('id')->on('professeurs')->onDelete('cascade');
            $table->unsignedBigInteger('classe_id'); 
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
        Schema::dropIfExists('evaluations');
    }
};
