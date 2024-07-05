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
        Schema::create('etablissements', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('directeur');
            $table->string('adresse');
            $table->string('telephone');
            $table->string('email');
            $table->enum('type',['privé', 'public']);
            $table->unsignedBigInteger('administrateur_id');
           $table->foreign('administrateur_id')->references('id')->on('administrateurs')->onDelete('cascade');
           $table->unsignedBigInteger('etablissement_id')->nullable();

           $table->foreign('etablissement_id')->references('id')->on('etablissements')->onDelete('set null');
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
        Schema::dropIfExists('etablissements');
    }
};
