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
        Schema::create('medical_sessions', function (Blueprint $table) {
            $table->id();
            $table->uuid() ;
            $table->foreignId('doctor_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('patiant_id')->references('id')->on('patiants')->onDelete('cascade');
            $table->foreignId('appointment_id')->references('id')->on('appointment')->onDelete('cascade');
            $table->text('complaint') ;
            $table->text('diagnoseis') ;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_sessions');
    }
};
