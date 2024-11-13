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
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->integer('valeur');
            $table->text('appreciations');
            $table->string('semestre')->nullable();
            $table->integer('coefficient');
            $table->boolean('is_deleted')->default(false);
            $table->unsignedBigInteger('evaluation_id');
            $table->unsignedBigInteger('eleve_id');
            $table->unsignedBigInteger('professeur_id');
            $table->foreign('evaluation_id')->references('id')->on('evaluations')->onDelete('cascade');
            $table->foreign('eleve_id')->references('id')->on('eleves')->onDelete('cascade');
            $table->foreign('professeur_id')->references('id')->on('professeurs')->onDelete('cascade');
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
        Schema::dropIfExists('notes');
    }
};
