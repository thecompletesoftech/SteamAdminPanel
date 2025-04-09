<?php

namespace App\Models;

namespace App\Models;

use App\Services\FileService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Spatie\Permission\Traits\HasRoles;

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
