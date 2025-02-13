<?php

namespace App\Models;

use App\Traits\Uuid;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use Uuid;

    protected $fillable = [
        'day',
        'start_time',
        'end_time',
        'specific_date',
        'information',
        'is_active',
    ];

    protected $casts = [
        'specific_date' => 'date',
        'start_time' => 'string', // Ubah ke string jika perlu
        'end_time' => 'string',
    ];
}
