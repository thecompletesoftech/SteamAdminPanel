<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class VehicletypeModal extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'vehicle_type';
    protected $primaryKey = 'id';

    protected $fillable =
    [
       'vehicle_type',
       'type_image',
       
    ];
}
