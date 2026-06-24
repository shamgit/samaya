<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
            Schema::create('purchase_order', function (Blueprint $table) {
            $table->id();
            $table->string('purchase_requisition_id')->nullable();
            $table->unsignedBigInteger('supplier_id');
            $table->string('po_no')->nullable();
            $table->date('po_date')->nullable();
            $table->date('delivery_date')->nullable();
            $table->string('delivery_location')->nullable();
            $table->string('payment_terms')->nullable();
            $table->text('notes')->nullable();
            $table->decimal('gst_rate', 5, 2)->default(0);
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('gst_amount', 12, 2)->default(0);
            $table->decimal('total_amount', 12, 2)->default(0);
            $table->string('attachment')->nullable();
            $table->string('status')->default('Created');
            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_order');
    }
};