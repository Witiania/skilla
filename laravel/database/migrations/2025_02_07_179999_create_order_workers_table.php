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
        Schema::create('order_workers', function (Blueprint $table) {
            $table->foreignId('order_id')->constrained('orders');
            $table->foreignId('worker_id')->constrained('workers');
            $table->decimal('amount', 10, 2);
            $table->timestamps();

            $table->primary(['order_id', 'worker_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_workers');
    }
};
