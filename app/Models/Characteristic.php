<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Characteristic extends Model
{
    protected $fillable = [
        'category_id', 'name', 'unit', 'value_type', 'is_filterable', 'sort_order'
    ];

    protected function casts(): array
    {
        return ['is_filterable' => 'boolean'];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_characteristic_values')
            ->withPivot(['value_number', 'value_text'])
            ->withTimestamps();
    }
}
