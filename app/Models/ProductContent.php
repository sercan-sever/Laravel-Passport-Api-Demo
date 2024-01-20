<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductContent extends Model
{
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id',
        'short_statement',
        'statement',
        'price',
        'image',
        'type',
        'created_at',
        'updated_at',
    ];

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class)->withDefault();
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return (!empty($this->image) && file_exists(public_path('images/products/' . $this->image)))
            ? asset('images/products/' . $this->image)
            : asset('default/none-logo.png');
    }
}
