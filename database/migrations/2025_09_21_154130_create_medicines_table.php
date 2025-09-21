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
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->uuid() ;
            $table->string('drug_name') ;
            $table->string('dosage') ;
            $table->string('frequency') ;
            $table->string('duration') ;
            $table->string('instructions') ;
            $table->foreignId('session_id')->references('id')->on('medical_sessions')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
