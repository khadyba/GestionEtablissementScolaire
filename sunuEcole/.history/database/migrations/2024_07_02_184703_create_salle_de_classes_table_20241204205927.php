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
        Schema::create('salle_de_classes', function (Blueprint $table) {
            $table->id();
            $table->integer('numéro');
            $table->integer('capaciter');
            $table->enum('statut', ['libre', 'occupée'])->default('libre');
            $table->boolean('is_deleted')->default(false); 
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
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
        Schema::dropIfExists('salle_de_classes');
    }
};
