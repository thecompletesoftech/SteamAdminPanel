<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ManagerFeedbackModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'managerfeedback';
    protected $primaryKey = 'id';

    protected $fillable =
    [

       'Service_request_id',
       'manager_feedback_id',
       'discription',

    ];
}
