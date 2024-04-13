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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->integer('installments_quantity')->default(1);
            $table->integer('installments_number');
            $table->decimal('installments_value');
            $table->date('due_date');
            $table->date('payment_date');
            $table->unsignedBigInteger('contract_service_id');
            $table->foreign('contract_service_id')->references('id')->on('contract_service');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
