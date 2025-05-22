<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sub_services extends Model
{
    use HasFactory;
    
    protected $table = 'sub_services';
    protected $primaryKey = 'sub_id';

    protected $fillable =
    [
       'id',
       'sub_service_name',
       
    ];
}
