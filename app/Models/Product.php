<?php

namespace App\Models;

use App\Enums\StatusEnum;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;


    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'content',
        'status',
        'created_at',
        'updated_at',
    ];


    /**
     * @var array<string, StatusEnum>
     */
    protected $casts = [
        'status' => StatusEnum::class,
    ];


    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault();
    }


    /**
     * @return HasOne
     */
    public function content(): HasOne
    {
        return $this->hasOne(ProductContent::class)->withDefault();
    }
}
