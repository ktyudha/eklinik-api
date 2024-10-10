<?php

namespace App\Models;

use App\Traits\Uuid;
use App\Models\Medical;
use App\Models\Patient;
use App\Models\Medicine\Recipe;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use Uuid;

    public $table = 'payments';
    protected $fillable = [
        'patient_id',
        'medical_id',
        'recipe_id',
        'payment_date',
        'payment_method',
        'status',
        'total_amount',
        'snap_token'
    ];

    public function setPending()
    {
        $this->attributes['status'] = 'pending';
        self::save();
    }

    public function setSuccess()
    {
        $this->attributes['status'] = 'success';
        self::save();
    }

    public function setFailed()
    {
        $this->attributes['status'] = 'failed';
        self::save();
    }

    public function setExpired()
    {
        $this->attributes['status'] = 'expired';
        self::save();
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function medical()
    {
        return $this->belongsTo(Medical::class);
    }

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }
}
