<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id('order_id');
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict');
            $table->foreignId('address_id')->constrained('addresses', 'address_id')->onDelete('restrict');
            $table->foreignId('payment_id')->constrained('payment_methods', 'payment_id')->onDelete('restrict');
            $table->timestamp('order_date');
            $table->enum('status', ['pending', 'processing', 'shipped', 'delivered', 'cancelled']);
            $table->decimal('total_amount', 10, 2);
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id('order_item_id');
            $table->foreignId('order_id')->constrained('orders', 'order_id')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products', 'product_id')->onDelete('restrict');
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->timestamps();
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->id('payment_record_id');
            $table->foreignId('order_id')->constrained('orders', 'order_id')->onDelete('restrict');
            $table->foreignId('payment_id')->constrained('payment_methods', 'payment_id')->onDelete('restrict');
            $table->decimal('amount', 10, 2);
            $table->timestamp('transaction_date');
            $table->string('gateway_status');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
}; 