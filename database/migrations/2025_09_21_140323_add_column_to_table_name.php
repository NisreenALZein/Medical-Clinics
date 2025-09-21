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
        Schema::table('users', function (Blueprint $table) {
            //
            $table->uuid() ;
            $table->enum('gender',['male','fmale']) ;
            $table->integer('age') ;
            $table->string('phone')->unique();
            $table->string('address');
            $table->enum('role',['admin','doctor','assistance','receptionist'])->default('doctor') ;






        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
