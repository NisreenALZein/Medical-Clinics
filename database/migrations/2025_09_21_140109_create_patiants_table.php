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
        Schema::create('patiants', function (Blueprint $table) {
            $table->id();
            $table->uuid() ;
            $table->string('email')->unique();
            $table->enum('gender',['male','fmale']) ;
            $table->integer('age') ;
            $table->string('phone')->unique();
            $table->string('address');
            $table->boolean('archived')->default('false') ;
            $table->date('archived_at')->nullable() ;

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patiants');
    }
};
