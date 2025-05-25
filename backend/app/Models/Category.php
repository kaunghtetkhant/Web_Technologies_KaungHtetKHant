<?php

namespace App\Models;

use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
   use HasFactory;

    protected static function newFactory()
    {
        return CategoryFactory::new();
    }
    public  function subcategories() : HasMany
    {
        return $this->hasMany(Subcategory::class);
    }
}
