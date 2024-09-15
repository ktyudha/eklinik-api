<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class Classification extends Model
{
    use Uuid;

    public $table = 'classifications';
    protected $fillable = [
        'menu_id',
        'name',
        'description',
        'price',
        'is_active',

    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
