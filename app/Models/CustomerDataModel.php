<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerDataModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'customerdata';
    protected $primaryKey = 'id';

    protected $fillable =
    [
        'customer_name',
        'flow',
        'pressure',
        'temprature',
        'totalizer',
        // 'Last_reading_time',

    ];
}
