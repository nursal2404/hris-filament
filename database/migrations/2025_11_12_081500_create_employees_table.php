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
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('employee_id');
            $table->string('address');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('position_id');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')           
                ->on('users')               
                ->onDelete('cascade');

            $table->foreign('department_id')
                ->references('department_id') 
                ->on('departments')          
                ->onDelete('cascade');

            $table->foreign('position_id')
                ->references('position_id') 
                ->on('positions')          
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
