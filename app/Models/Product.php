<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'product';
    protected $primaryKey = 'id';

    protected $fillable =
    [
       'product_category',
       'product_name',
       'product_image',
       'product_price',
       'product_specification',
       'product_stock',
       'product_status',
       'uploaded_by',
       'vendor_id',
    ];
}
