<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RaiseComplainModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'raise_complain';
    protected $primaryKey = 'id';

    protected $fillable =
    [
       'user_id',
       'company_name',
       'pictures',
       'number',
       'discription',

    ];
}
