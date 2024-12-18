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
        Schema::create('eleves', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenoms');
            $table->string('adresse');
            $table->string('non_de_votre_tuteur');
            $table->string('email_tuteur');
            $table->date('dateDeNaissance');
            $table->unsignedBigInteger('classe_id')->nullable();
            $table->boolean('is_completed')->default(false); 
            $table->unsignedBigInteger('user_id');
            $table->foreign('classe_id')->references('id')->on('classes')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('parents');
            $table->unsignedBigInteger('etablissement_id')->nullable(); 
            $table->foreign('etablissement_id')->references('id')->on('etablissements')->onDelete('set null'); // Assure la relation
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
        Schema::dropIfExists('eleves');
    }
};
