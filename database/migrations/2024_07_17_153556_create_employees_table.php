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
            $table->id('employeeId')->index();
            $table->string('firstName', 200);
            $table->string('lastName', 200);
            $table->string('gender', 10);
            $table->string('address', 200);
            $table->string('nic', 100);
            $table->date('joiningDate');
            $table->date('resignedDate')->nullable();
            $table->integer('departmentId');
            $table->string('contactNo',15);
            $table->timestamps();
            $table->softDeletes(); 
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
