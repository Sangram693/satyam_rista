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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number',50)->unique();
            $table->string('bill_file', 255);
            $table->decimal('total_amount', 10, 2);
            $table->unsignedBigInteger('dealer_distributor_id');
            $table->foreign('dealer_distributor_id')->references('id')->on('dealer_distributors')->onDelete('cascade');
            $table->enum('status', ['paid', 'unpaid'])->default('unpaid');
            $table->boolean('is_verified')->default(false);
            $table->string('transaction_id', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
