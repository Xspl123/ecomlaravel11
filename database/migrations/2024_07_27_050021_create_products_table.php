<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('brand_id');
            $table->text('short_description');
            $table->text('description');
            $table->decimal('regular_price', 10, 2);
            $table->decimal('sale_price', 10, 2);
            $table->string('SKU')->unique();
            $table->integer('quantity');
            $table->enum('stock_status', ['instock', 'outofstock']);
            $table->boolean('featured')->default(0);
            $table->string('image')->nullable();
            $table->json('gallery_images')->nullable();
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
        });
    }



    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
