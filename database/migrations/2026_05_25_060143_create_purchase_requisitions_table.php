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
        Schema::create('purchase_requisitions', function (Blueprint $table) {

            $table->id();

            $table->string('requisition_id')->unique();

            $table->unsignedBigInteger('department_id')->nullable();

            $table->string('requested');

            $table->date('request_date')->nullable();

            $table->date('required_date')->nullable();  

             $table->string('priority')->default('Normal');

             $table->text('remarks')->nullable();
             $table->string('status')->default('Pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_requisitions');
    }
};