<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Omaressaouaf\LaravelIdGenerator\IdGenerator;

class Product extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return ProductFactory::new();
    }

    public  function subcategory() : BelongsTo
    {
        return $this->belongsTo(Subcategory::class);
    }

    public  function brand() : BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
             $model->code_no = (Product::where('id', $model->id)->max('id') ?? 0) + 1;
            // Compose the full serial
            $model->code_no = 'CNo' . '-' . $model->code_no;
        });
    }
}
