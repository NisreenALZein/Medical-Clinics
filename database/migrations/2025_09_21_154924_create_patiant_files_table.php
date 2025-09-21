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
        Schema::create('patiant_files', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->foreignId('patiant_id')->references('id')->on('patiants')->onDelete('cascade');
            $table->string('file-path') ;
            $table->enum('type',['image','pdf']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patiant_files');
    }
};
