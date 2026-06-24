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
        Schema::create('menu_groups', function (Blueprint $table) {

            $table->id('menu_group_id');

            $table->string('menu_group_name');

            $table->string('menu_group_icon')->nullable();

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
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_groups');
    }
};
