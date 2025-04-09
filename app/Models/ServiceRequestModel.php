<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceRequestModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'service_request';
    protected $primaryKey = 'id';

    protected $fillable =
    [
        'emp_id',
        'user_id',
        'manger_id',
       'Service_request',
       'pictures',
       'phone',
       'discription',
       'latitude',
       'longitude',
       'address',
       'otp',
       'mob_verify',

    ];
}
