<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{

    protected $guarded=[];
    use HasFactory;

    public function products():HasMany
    {
        return $this->hasMany(Product::class,'category_id')->where('status','1');
    }

    //Home page limit 5 products
    public function limitProduct():HasMany
    {
        return $this->hasMany(Product::class,'category_id')->where('status','1')->latest()->take(5);
    }

    //Product count

    public function productCount():HasMany
    {
        return $this->hasMany(Product::class,'category_id')->where('status','1');
    }
}
