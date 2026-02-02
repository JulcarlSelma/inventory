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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->integer('stocked_count')->default(0);
            $table->date('stocked_date')->nullable();
            $table->boolean('out_of_stock')->default(false);
            $table->timestamps();
            $table->softDeletes();

            // Foreign Key
            $table->foreign('product_id')->references('id')->on('products')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
