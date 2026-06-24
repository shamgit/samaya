<?php 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'purchase_order_items',
            function (Blueprint $table) {

                $table->id();

                $table->unsignedBigInteger(
                    'po_id'
                );

                $table->unsignedBigInteger(
                    'product_id'
                );

                $table->decimal(
                    'qty',
                    10,
                    2
                );

                $table->decimal(
                    'unit_price',
                    12,
                    2
                );

                $table->decimal(
                    'total',
                    12,
                    2
                );

                $table->timestamps();


                $table->foreign(
                    'po_id'
                )

                ->references(
                    'id'
                )

                ->on(
                    'purchase_orders'
                )

                ->onDelete(
                    'cascade'
                );


                $table->foreign(
                    'product_id'
                )

                ->references(
                    'id'
                )

                ->on(
                    'products'
                )

                ->onDelete(
                    'cascade'
                );

            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists(
            'purchase_order_items'
        );
    }
};