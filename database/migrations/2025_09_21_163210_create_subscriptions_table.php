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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('plan_id')->references('id')->on('plans')->onDelete('cascade');
            $table->date('startDate') ;
            $table->date('endDate') ;
            $table->enum('paymentGateway',['stripe','paytabs','checkout']);
            $table->boolean('autoRenew') ;
            $table->enum('status',['active','canceled','expired','pending'])->default('pending');




            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
