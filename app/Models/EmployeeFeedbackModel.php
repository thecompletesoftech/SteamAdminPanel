<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeFeedbackModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'employee_feedback';
    protected $primaryKey = 'id';

    protected $fillable =
    [
        'Service_request_id',
        'employee_id',
        'pictures',
        'remark',

    ];
}
