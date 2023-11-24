<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function vendor():BelongsTo
    {
        return $this->belongsTo(User::class,'vendor_id');
    }

    public function subcategory():BelongsTo
    {
        return $this->belongsTo(SubCategory::class,'subcategory_id');
    }
    public function category():BelongsTo
    {
        return $this->belongsTo(Category::class,'category_id');
    }



    public function images():HasMany
    {
         return $this->hasMany(ProductImage::class,'product_id');
    }

    public function brands():BelongsTo{
        return $this->belongsTo(Brand::class,'brand_id');
    }


}
