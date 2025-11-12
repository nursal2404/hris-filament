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
        Schema::create('payrolls', function (Blueprint $table) {
            $table->bigIncrements('payroll_id');
            $table->unsignedBigInteger('employee_id');
            $table->decimal('salary', 10, 2);
            $table->date('pay_date');
            $table->timestamps();

            $table->foreign('employee_id')
                ->references('employee_id') 
                ->on('employees')          
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
