<?php

namespace App\Traits;

use App\Models\Clinic;

trait BelongsToClinic
{

    public function clinic()
    {
        return $this->belongsTo(Clinic::class)->where('active','=',1);
    }

    protected static function booted()
    {
        static::addGlobalScope('clinic', function ($query) {
            $clinic = app()->make('clinic.active');
            $query->where('clinic_id' , $clinic->id);

        });
    }
}
