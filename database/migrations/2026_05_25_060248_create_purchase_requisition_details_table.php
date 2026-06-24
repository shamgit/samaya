<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchase_requisition_details', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('purchase_requisition_id');

            $table->unsignedBigInteger('product_id');

            $table->string('category')->nullable();

            $table->string('color')->nullable();

            $table->string('size')->nullable();

            $table->integer('quantity')->default(1);

            $table->string('unit')->nullable();

            $table->timestamps();

            $table->foreign('purchase_requisition_id')
                  ->references('id')
                  ->on('purchase_requisitions')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_requisition_details');
    }
};
