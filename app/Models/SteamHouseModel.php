<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SteamHouseModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'steamhouse';
    protected $primaryKey = 'steamhouse_id';

    protected $fillable =
    [
       'pressure',
       'temprature',
       'flow',
       'totalizer',
    ];
}
