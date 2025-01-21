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
        Schema::create('dealer_distributors', function (Blueprint $table) {
            $table->id(); 
            $table->string('bank_statement')->nullable();
            $table->string('gstin', 50)->unique();
            $table->string('gst_certificate')->nullable();
            $table->string('did', 100)->unique();
            $table->string('name', 200);
            $table->string('phone_number', 20)->unique();
            $table->string('email', 200)->unique();
            $table->string('username', 100)->unique();
            $table->string('password'); 
            $table->text('address')->nullable();
            $table->string('zone', 100)->nullable();
            $table->string('pan_card', 50)->unique();
            $table->boolean('is_verified')->default(false);
            $table->enum('type', ['dealer', 'distributor']);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->unsignedBigInteger('salesman_id')->nullable();
            $table->timestamps();

            $table->foreign('salesman_id')->references('id')->on('salesmen')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dealer_distributors');
    }
};
