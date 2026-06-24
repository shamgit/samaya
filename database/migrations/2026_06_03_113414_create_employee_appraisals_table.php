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
        Schema::create('employee_appraisals', function (Blueprint $table) {
            $table->id('appraisal_id');
            $table->unsignedBigInteger('employee_id');

            $table->string('employee_code')->nullable();

            $table->unsignedBigInteger('designation_id')->nullable();

            $table->unsignedBigInteger('department_id')->nullable();

            $table->string('review_period')->nullable();

            $table->integer('rating_scale')->default(1);

            $table->decimal('salary_increment_recommendation', 12, 2)->nullable();

            $table->longText('manager_feedback')->nullable();

            $table->tinyInteger('status')->default(1);

            $table->tinyInteger('deleted')->default(0);

            $table->bigInteger('created_by')->nullable();

            $table->bigInteger('updated_by')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_appraisals');
    }
};
