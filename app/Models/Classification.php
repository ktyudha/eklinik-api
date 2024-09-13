<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class Classification extends Model
{
    use Uuid;

    public $table = 'classifications';
    protected $fillable = [
        'name',
        'description',
        'price',
    ];
}
