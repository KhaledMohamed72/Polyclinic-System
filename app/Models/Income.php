<?php

namespace App\Models;

use App\Traits\BelongsToClinic;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;
    use BelongsToClinic;
    protected $fillable = [
        'clinic_id',
        'doctor_id',
        'income_type_id',
        'date',
        'amount',
        'note',
        ];
}
