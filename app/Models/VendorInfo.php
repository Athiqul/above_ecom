<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VendorInfo extends Model
{
    protected $guarded=[];
    use HasFactory;

    public function vendorinfo():BelongsTo
    {
        return $this->belongsTo(User::class,'vendor_id');
    }
}
