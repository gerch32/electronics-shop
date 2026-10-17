<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'name', 'slug', 'description', 'price', 'image', 'is_active', 'sku'
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // Магазины, где товар есть в ассортименте, с остатком в pivot->quantity
    public function stores(): BelongsToMany
    {
        return $this->belongsToMany(Store::class, 'store_products')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    // Характеристики товара со значениями в pivot
    public function characteristics(): BelongsToMany
    {
        return $this->belongsToMany(Characteristic::class, 'product_characteristic_values')
            ->withPivot(['value_number', 'value_text'])
            ->withTimestamps();
    }
}
