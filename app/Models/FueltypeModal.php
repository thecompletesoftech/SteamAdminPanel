<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class FueltypeModal extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'fuel_type';
    protected $primaryKey = 'id';

    protected $fillable =
    [
       'fuel_type',
       
    ];
}
