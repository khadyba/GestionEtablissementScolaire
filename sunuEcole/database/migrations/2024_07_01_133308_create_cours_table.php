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
            $table->dateTime('heure_debut');
            $table->date('heure_fin');
            $table->string('file_path');
            $table->unsignedBigInteger('professeurs_id');
            $table->unsignedBigInteger('classes_id');
            $table->foreign('professeurs_id')->references('id')->on('cours')->onDelete('cascade');
            $table->foreign('classes_id')->references('id')->on('cours')->onDelete('cascade');
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
