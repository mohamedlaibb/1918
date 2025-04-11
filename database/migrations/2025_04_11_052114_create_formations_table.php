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
            $table->date('date_fin'); // End date (YYYY-MM-DD)
            $table->foreign('client_id')->references('client_id')->on('clients');

            $table->timestamps(); // Automatic created_at and updated_at

            // Optional: Add index for better performance
            $table->index(['client_id', 'date_debut']);
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
