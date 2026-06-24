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
        Schema::create('suppliers', function (Blueprint $table) {

            $table->bigIncrements('supplier_id');

            $table->string('supplier_name');
            $table->string('contact_person_name');

            $table->string('email')->nullable();
            $table->string('phone', 20);

            $table->text('address');

            $table->string('city');
            $table->string('state');

            $table->string('zip_code', 20);

           
            $table->unsignedInteger('category_id')->nullable();

            $table->string('gst_tex')->nullable();

            $table->unsignedInteger('payment_term_id')->nullable();

           
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('ifsc_code')->nullable();

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
        Schema::dropIfExists('suppliers');
    }
};
