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
        Schema::create('time_trackings', function (Blueprint $table) {

            $table->id('time_tracking_id');

            $table->unsignedBigInteger('employee_id');

            $table->string('employee_code')->nullable();

            $table->unsignedBigInteger('designation_id')->nullable();

            $table->unsignedBigInteger('department_id')->nullable();

            $table->string('project_task')->nullable();

            $table->string('form_date')->nullable();

            $table->string('start_time');

            $table->string('end_time');

            $table->string('total_work_hours')->nullable();

            $table->longText('dask_description')->nullable();

            $table->integer('status')->default(1);

            $table->integer('deleted')->default(0);

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
        Schema::dropIfExists('time_trackings');
    }
};
