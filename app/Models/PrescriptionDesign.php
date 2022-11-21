<?php

namespace App\Models;

use App\Traits\BelongsToClinic;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrescriptionDesign extends Model
{
    use HasFactory;
    use BelongsToClinic;
}
