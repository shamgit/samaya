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

            $table->id('attendance_id');

            $table->unsignedBigInteger('employee_id');

            $table->unsignedBigInteger('department_id');

            $table->string('employee_code')->unique();

            $table->date('attendance_date');

            $table->time('check_in')->nullable();

            $table->time('check_out')->nullable();

            $table->unsignedBigInteger('attendance_status_id');

            $table->integer('created_by')->nullable();

            $table->integer('updated_by')->nullable();

            $table->integer('deleted')->default(0);

            $table->timestamps();

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
