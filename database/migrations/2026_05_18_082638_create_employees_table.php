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

            $table->unsignedBigInteger('designation_id')->nullable();

            $table->unsignedBigInteger('department_id')->nullable();

            $table->unsignedBigInteger('role_id')->nullable();

            $table->string('employee_name');

            $table->string('employee_code')->unique();

            $table->string('phone');

            $table->string('gender');

            $table->string('date_of_birth');

            $table->string('email');

            $table->text('address');

            $table->string('city');

            $table->string('state');

            $table->string('zip_code');

            $table->string('joining_date');

            $table->string('employee_type');

            $table->string('company_name');

            $table->text('employee_document');

            $table->string('bank_name');

            $table->string('bank_account_no');

            $table->string('ifsc_code');

            $table->text('bank_address');

            $table->string('pf_number')->nullable();

            $table->string('payment_type')->default(0);

            $table->decimal('basic_salary', 10, 2)->default(0);

            $table->decimal('allowances', 10, 2)->default(0);

            $table->decimal('total_salary', 10, 2)->default(0);

            $table->tinyInteger('status')->default(1);

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
        Schema::dropIfExists('employees');
    }
};
