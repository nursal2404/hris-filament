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
        Schema::create('attendances', function (Blueprint $table) {
            $table->bigIncrements('attendance_id');
        $table->unsignedBigInteger('employee_id'); 
        $table->date('date');
        $table->time('check_in')->nullable();
        $table->time('check_out')->nullable();

        $table->enum('status', ['present', 'permit', 'sick', 'leave', 'absent'])
                ->default('absent');

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
        Schema::dropIfExists('attendances');
    }
};
