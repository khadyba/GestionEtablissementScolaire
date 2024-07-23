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
        Schema::create('cours', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->longText('descriptions');
            $table->date('jours');
            $table->time('heure_debut');
            $table->time('heure_fin'); 
            $table->string('fichier_cours');
            $table->unsignedBigInteger('professeur_id'); 
            $table->unsignedBigInteger('classe_id'); 
            $table->unsignedBigInteger('salle_de_classe_id')->nullable();
            $table->foreign('salle_de_classe_id')->references('id')->on('salle_de_classes')->onDelete('cascade');
            $table->foreign('professeur_id')->references('id')->on('professeurs')->onDelete('cascade'); 
            $table->foreign('classe_id')->references('id')->on('classes')->onDelete('cascade'); 
            $table->boolean('is_deleted')->default(false); 
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
        Schema::dropIfExists('cours');
    }
};
