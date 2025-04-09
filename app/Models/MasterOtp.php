<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterOtp extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $fillable = [
        'phone',
        'otp',
        'service_request_id',
        'role_id',
    ];
}
