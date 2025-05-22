<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class UserVehicleModal extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'user_vehicle';
    protected $primaryKey = 'id';

    protected $fillable =
    [
       'vehicle_type_id',
       'manufacturer_id',
       'brand_id',
       'fuel_type_id',
       'default_vehicle',
       'user_id',
       
    ];
}
