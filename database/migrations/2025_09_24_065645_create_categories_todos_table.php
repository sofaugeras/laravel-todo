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
        Schema::create('categories_todos', function (Blueprint $table) {
            $table->integer('categories_id');
            $table->integer('todos_id');
            // Clé primaire composée
            $table->primary(['categories_id', 'todos_id']);
            // Clés étrangères
            $table->foreign('categories_id')->references('id')->on('categories');
            $table->foreign('todos_id')->references('id')->on('todos')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories_todos');
    }
};
