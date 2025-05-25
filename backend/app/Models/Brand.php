<?php

namespace App\Models;

use Database\Factories\BrandFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    use HasFactory;

    protected static  function newFactory()
    {
        return BrandFactory::new();
    }

    public  function products() : HasMany
    {
        return $this->hasMany(Product::class);
    }
}
