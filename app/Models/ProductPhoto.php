<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPhoto extends Model
{
    protected $fillable = [
        'product_id',
        'disk',
        'path',
        'url',
        'caption',
        'sort_order',
        'is_cover',
        'width',
        'height',
        'mime',
        'size_bytes'
    ];

    protected $casts = [
        'is_cover' => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    public function publicUrl(): string
    {
        return asset($this->path);
    }
}
