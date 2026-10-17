<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            // Категорию с товарами удалить нельзя.
            $table->foreignId('category_id')->constrained()->restrictOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2); // единая цена для всей сети
            $table->string('image')->nullable();
            // Товары с заказами не удаляем, а скрываем.
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Ускоряет выборки вида «товары категории до N рублей».
            $table->index(['category_id', 'price']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
