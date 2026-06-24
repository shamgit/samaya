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
        Schema::create('designations', function (Blueprint $table) {
            $table->bigIncrements('designation_id');

            $table->unsignedBigInteger('user_id')->nullable();

            $table->unsignedBigInteger('role_id')->nullable();

            $table->string('name');

            $table->text('description')->nullable();

            
            $table->longText('access_menus')->nullable();

            $table->tinyInteger('designation_type')->default(1);

        
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
        Schema::dropIfExists('designations');
    }
};
