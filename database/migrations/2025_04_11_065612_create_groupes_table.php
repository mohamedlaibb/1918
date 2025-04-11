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
        Schema::create('groupes', function (Blueprint $table) {
            $table->id();

//            $table->foreignId('formation_id')->constrained()->onDelete('cascade');
//            $table->foreignId('session_id')->constrained()->onDelete('cascade');

            $table->unsignedBigInteger('formation_id');
            $table->unsignedBigInteger('session_id');

            $table->foreign('formation_id')
                ->references('id')
                ->on('formations')
                ->onDelete('cascade');

            $table->foreign('session_id')
                ->references('id')
                ->on('sessions')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groupes');
    }
};
