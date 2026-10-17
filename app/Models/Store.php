<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Store extends Model
{
    protected $fillable = ['name', 'city', 'address', 'is_active'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    // Сотрудники магазина (директор и менеджеры)
    public function staff(): HasMany
    {
        return $this->hasMany(User::class);
    }

    // Товары в ассортименте магазина с остатком в pivot->quantity
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'store_products')
            ->withPivot('quantity')
            ->withTimestamps();
    }
}
