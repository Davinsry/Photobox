<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlockedSchedule extends Model
{
    protected $fillable = [
        'blocked_date',
        'start_time',
        'end_time',
        'reason',
    ];
}
