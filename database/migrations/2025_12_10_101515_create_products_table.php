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

        $table->string('product_title');
        $table->text('product_description');
        $table->integer('product_quantity');
        $table->decimal('product_price', 10, 2);
        $table->text('product_image');
        $table->boolean('is_popular')->default(false);
        $table->foreignId('category_id')
              ->nullable()
              ->constrained('categories')
              ->onDelete('cascade');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
