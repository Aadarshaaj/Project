<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'rating',
        'title',
        'body',
        'verified_purchase',
        'size_rating',
        'fit_rating',
        'images',
        'metadata',
    ];

    protected $casts = [
        'rating' => 'integer',
        'verified_purchase' => 'boolean',
        'size_rating' => 'integer',
        'fit_rating' => 'integer',
        'images' => 'array',
        'metadata' => 'array',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
