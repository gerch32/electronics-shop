<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Справочник: какие характеристики бывают у товаров категории
        Schema::create('characteristics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->restrictOnDelete();
            $table->string('name');                       // «Оперативная память»
            $table->string('unit', 20)->nullable();       // «ГБ»
            $table->string('value_type', 10)->default('number'); // number | text
            $table->boolean('is_filterable')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['category_id', 'name']);
        });

        // Значения характеристик конкретных товаров
        Schema::create('product_characteristic_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('characteristic_id')->constrained()->restrictOnDelete();
            $table->decimal('value_number', 12, 2)->nullable();
            $table->string('value_text')->nullable();
            $table->timestamps();

            $table->unique(['product_id', 'characteristic_id'], 'pcv_product_characteristic_unique');
            $table->index(['characteristic_id', 'value_number'], 'pcv_characteristic_number_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_characteristic_values');
        Schema::dropIfExists('characteristics');
    }
};
