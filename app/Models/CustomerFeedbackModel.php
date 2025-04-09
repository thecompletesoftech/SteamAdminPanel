<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerFeedbackModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'customerfeedback';
    protected $primaryKey = 'id';

    protected $fillable =
    [
       'Service_request_id',
       'customer_feedback_id',
       'star',
       'discription',

    ];
}
