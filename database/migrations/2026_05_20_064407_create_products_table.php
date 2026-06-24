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
        Schema::create('products', function (Blueprint $table) {

            $table->id();

            $table->unsignedInteger('category_id');

            $table->text('product_image');

            $table->string('product_name');

            $table->string('product_code', 100);

            $table->string('unit_of_measure');

            $table->string('product_color');

            $table->integer('supplier_id');

            $table->string('cost_price', 250);

            $table->string('warehouse_location');

            $table->string('reorder_level')->default('1');

            $table->unsignedInteger('created_by');

            $table->unsignedInteger('updated_by')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
