<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'collection_id',
        'name',
        'slug',
        'short_description',
        'description',
        'price',
        'compare_at_price',
        'sku',
        'stock_quantity',
        'is_active',
        'is_new',
        'is_bestseller',
        'is_sustainable',
        'metadata',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'compare_at_price' => 'decimal:2',
        'is_active' => 'boolean',
        'is_new' => 'boolean',
        'is_bestseller' => 'boolean',
        'is_sustainable' => 'boolean',
        'metadata' => 'array',
    ];

    public function collection(): BelongsTo
    {
        return $this->belongsTo(Collection::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function media(): HasMany
    {
        return $this->hasMany(ProductMedia::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
