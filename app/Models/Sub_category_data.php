<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Sub_category_data extends Model
{
     use HasFactory, SoftDeletes;
     protected $table = 'sub_category_data';
    protected $primaryKey = 'id';

    protected $fillable =
    [
       'sub_services_id',
       'sub_service_data',
       'link_with_product',
       'product_category',
       
    ];
}
