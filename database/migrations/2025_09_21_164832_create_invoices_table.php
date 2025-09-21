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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->foreignId('session_id')->references('id')->on('medical_sessions')->onDelete('cascade');
            $table->foreignId('payment_id')->references('id')->on('payments')->onDelete('cascade');
            $table->string('invoiceNumber')->unique() ;
            $table->decimal('amount',10,2) ;
            $table->decimal('discount',10,2) ;
            $table->decimal('finalAmount',10,2) ;
            $table->enum('status',['paid','unpaid','canceled'])->default('unpaid');
            $table->date('issued_at') ;
            $table->date('due_date') ;


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
