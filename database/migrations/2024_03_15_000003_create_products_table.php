<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id('product_id');
            $table->foreignId('brand_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->integer('stock')->default(100);
            $table->string('image_url')->nullable();
            $table->decimal('alcohol_content', 4, 2)->nullable();
            $table->string('container_type')->default('Bottle'); // Bottle, Can, etc.
            $table->string('volume')->nullable(); // 330ml, 500ml, etc.
            $table->boolean('is_featured')->default(false);
            $table->integer('rating')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}; 