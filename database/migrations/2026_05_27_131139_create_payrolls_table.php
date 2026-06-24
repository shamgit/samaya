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

            $table->id('payroll_id');

            $table->bigInteger('employee_id');

            $table->string('employee_code')->nullable();

            $table->bigInteger('designation_id')->nullable();

            $table->bigInteger('department_id')->nullable();

            $table->string('pay_period_start_date')->nullable();

            $table->string('pay_period_end_date')->nullable();

            $table->string('pay_date')->nullable();

            $table->decimal('basic_salary', 12, 2)->default(0);

            $table->decimal('hra', 12, 2)->default(0);

            $table->decimal('transport_allowance', 12, 2)->default(0);

            $table->decimal('other_allowance', 12, 2)->default(0);

            $table->decimal('total_allowance', 12, 2)->default(0);

            $table->decimal('pf', 12, 2)->default(0);

            $table->decimal('professional_tax', 12, 2)->default(0);

            $table->decimal('other_deduction', 12, 2)->default(0);

            $table->decimal('total_deduction', 12, 2)->default(0);

            $table->decimal('income_tax', 12, 2)->default(0);

            $table->decimal('net_basic_salary', 12, 2)->default(0);

            $table->decimal('net_allowance', 12, 2)->default(0);

            $table->decimal('net_deduction', 12, 2)->default(0);

            $table->decimal('net_salary', 12, 2)->default(0);

            $table->tinyInteger('payroll_status')->default(1)->comment('1=Pending,2=Processed,3=Payslip');

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
        Schema::dropIfExists('payrolls');
    }
};
