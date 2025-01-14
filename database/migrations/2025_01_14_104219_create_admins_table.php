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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('super_admin_id')->nullable();
            $table->string('name',200);
            $table->string('email',200)->unique();
            $table->string('phone',200)->unique();
            $table->longText('address')->nullable();
            $table->string('employee_code',200)->unique();
            $table->date('hire_date');
            $table->enum('status', ['active', 'inactive', 'terminated'])->default('active');
            $table->double('sales_target')->nullable();
            $table->double('achieved_sales')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('super_admin_id')->references('id')->on('super_admins')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('sales_people')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('sales_people')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
