<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleBlock extends Model
{
    protected $fillable = [
        'block_date',
        'start_time',
        'end_time',
        'reason',
    ];
}
