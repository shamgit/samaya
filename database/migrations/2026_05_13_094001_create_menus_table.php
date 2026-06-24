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
        Schema::create('menus', function (Blueprint $table) {

            $table->id('menu_id');

            $table->unsignedBigInteger('menu_group_id');

            $table->string('menu_name');

            $table->string('menu_icon')->nullable();

            $table->string('menu_link')->nullable();

            $table->tinyInteger('status')
                  ->default(1)
                  ->comment('1=Active,2=Inactive');

            $table->tinyInteger('deleted')
                  ->default(0);

            $table->unsignedBigInteger('created_by')
                  ->nullable();

            $table->unsignedBigInteger('updated_by')
                  ->nullable();

            $table->timestamps();

            // Foreign Key
            $table->foreign('menu_group_id')
                  ->references('menu_group_id')
                  ->on('menu_groups')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
