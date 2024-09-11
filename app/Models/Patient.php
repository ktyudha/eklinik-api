<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use Uuid;


    public $table = 'patients';
    protected $fillable = [
        'no_medical_record',
        'name',
        'date_of_birth',
        'gender',
        'nik',
        'education',
        'job',
        'address',
    ];
    protected $casts = [
        'date_of_birth' => 'date',
    ];
}
