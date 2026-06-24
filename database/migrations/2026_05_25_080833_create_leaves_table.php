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
        Schema::create('leaves', function (Blueprint $table) {
            $table->id('leave_id');

            $table->unsignedBigInteger('employee_id');

            $table->string('employee_code')->nullable();

            $table->unsignedBigInteger('designation_id')->nullable();

            $table->unsignedBigInteger('department_id')->nullable();

            $table->unsignedBigInteger('leave_type_id');

            $table->string('from_date');

            $table->string('to_date');

            $table->longText('reason');

            $table->unsignedBigInteger('manager_approval')->nullable();

            $table->tinyInteger('leave_status')->default(1);

            // 1 = Pending
            // 2 = Approved
            // 3 = Rejected

            $table->tinyInteger('deleted')->default(0);

            $table->unsignedBigInteger('created_by')->nullable();

            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaves');
    }
};
