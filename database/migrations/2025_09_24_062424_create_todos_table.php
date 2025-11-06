<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('todos', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('texte');
            $table->boolean('termine')->default(0);
            $table->boolean('important')->default(0);

            $table->integer('listes_id')->nullable();
            $table->foreign('listes_id')->references('id')->on('listes');

            // ajout d'une date de fin
            $table->date('date_fin')->nullable();

            $table->integer('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');

            // Déclaraction de la clé primaire
            $table->primary('id');

            $table->timestamps();
            /* Utilisation du softDelete */
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('todos');
    }
};
