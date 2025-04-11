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
        Schema::create('formations', function (Blueprint $table) {
            $table->id();
            $table->string('titre'); // Formation title (required)
            $table->string('categorie'); // Training category
            $table->string('nom_formateur'); // Trainer's full name
            $table->integer('duree'); // Duration in hours
            $table->date('date_debut'); // Start date (YYYY-MM-DD)
            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps(); // Automatic created_at and updated_at


        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formations');
    }
};
