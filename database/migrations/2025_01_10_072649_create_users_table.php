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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('phone', 15);
            $table->string('user_id', 255);
            $table->string('email', 200);
            $table->text('password');
            $table->enum('role', ['fabricator', 'dealer', 'distributor']);
            $table->unsignedBigInteger('zone');
            $table->boolean('isVerified')->default(1);
            $table->timestamps();

            $table->foreign('zone')->references('id')->on('zones')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
