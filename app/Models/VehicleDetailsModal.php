<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class VehicleDetailsModal extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'vehicle';
    protected $primaryKey = 'id';

    protected $fillable =
    [
       'vehicle_name',
       'vehicle_image'
    ];
}
