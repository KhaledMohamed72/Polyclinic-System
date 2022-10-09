<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait GeneralTrait
{
    function insertWeeksDays($clinic_id, $doctor_id)
    {
        $weekDaysArray = array('Sat','Sun','Mon','Tue','Wed','Thu','Fri');
        for ($i = 0; $i < 7; $i++) {
            $doctorSchedule = DB::table('doctor_schedules')->insert([
                'clinic_id' => $clinic_id,
                'user_id' => $doctor_id,
                'day_of_week' => $weekDaysArray[$i],
                'day_attendance' => 0,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ]);
        }
        if ($doctorSchedule){
            return true;
        }
    }
}
