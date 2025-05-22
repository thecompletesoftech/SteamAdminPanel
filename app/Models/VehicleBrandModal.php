<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class VehicleBrandModal extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'vehicle_brand';
    protected $primaryKey = 'id';

    protected $fillable =
    [
       'vehicle_id',
       'brand_name',
       'brand_image'
    ];
}
