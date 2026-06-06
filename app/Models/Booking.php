<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'booking_code',
        'package_id',
        'guest_name',
        'guest_email',
        'guest_phone',
        'booking_date',
        'start_time',
        'end_time',
        'status',
        'notes',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
