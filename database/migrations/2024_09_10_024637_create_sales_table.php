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

            Schema::create('sales', function (Blueprint $table) {
                $table->ulid('id')->primary();
                $table->char('user_id',26);
                $table->char('product_id',26);
                $table->decimal('total_harga', 10, 2);
                $table->integer('jumlah');
                $table->enum('status', ['PENDING', 'COMPLETE'])->default('PENDING');
                $table->timestamps();
    
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
