<?php

namespace App\Repository;

use App\Http\Controllers\Controller;
use App\Repository\Interfaces\DoctorRepositoryInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Intervention\Image\Facades\Image;

class DoctorRepository extends Controller implements DoctorRepositoryInterface
{
    public function getDoctorRows()
    {
        // filter doctors according to role of current auth user
        if (auth()->user()->hasRole('admin')) {
            $rows = DB::table('users')
                ->join('doctors', 'doctors.user_id', '=', 'users.id')
                ->where('users.clinic_id', '=', $this->getClinic()->id)
                ->select('users.*', 'doctors.title')
                ->orderBy('users.id', 'desc')
                ->paginate(10);
        }
        if (auth()->user()->hasRole('recep')) {
            $rows = DB::table('users')
                ->join('doctors', 'doctors.user_id', '=', 'users.id')
                ->where('users.clinic_id', '=', $this->getClinic()->id)
                ->where('doctors.receptionist_id', '=', auth()->user()->id)
                ->select('users.*', 'doctors.title')
                ->orderBy('users.id', 'desc')
                ->paginate(10);
        }
        return $rows;
    }

    public function getReceptionistRows()
    {
        // filter doctors according to role of current auth user
        $rows = DB::table('users')
            ->join('receptionists', 'receptionists.user_id', '=', 'users.id')
            ->join('role_user', 'role_user.user_id', '=', 'receptionists.user_id')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->where('users.clinic_id', '=', $this->getClinic()->id)
            ->select('users.id', 'users.name')
            ->get();
        return $rows;
    }

    public function storeDoctor($request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'string'],
            'phone' => ['required', 'numeric', 'digits:11'],
            'title' => ['required', 'string', 'max:191'],
            'degree' => ['required', 'string', 'max:191'],
            'specialist' => ['required', 'string', 'max:191'],
            'slot_time' => ['required', 'numeric'],
            'examination_fees' => ['required', 'numeric'],
            'followup_fees' => ['required', 'numeric'],
            'bio' => ['nullable', 'string'],
            'receptionist' => ['required', 'integer'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048']
        ]);
        try {
            DB::beginTransaction();
            // insert general info into users table
            $user = DB::table('users')->insert([
                'clinic_id' => $this->getClinic()->id,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make('password'),
                'phone' => $request->phone,
                'profile_photo_path' => $this->storeImage($request),
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ]);
            $user_id = DB::getPdo()->lastInsertId();
            // insert the rest of info into Doctors table
            $doctor = DB::table('doctors')->insert([
                'clinic_id' => $this->getClinic()->id,
                'user_id' => $user_id,
                'receptionist_id' => $request->receptionist,
                'title' => $request->title,
                'degree' => $request->degree,
                'specialist' => $request->specialist,
                'slot_time' => $request->slot_time,
                'examination_fees' => $request->examination_fees,
                'followup_fees' => $request->followup_fees,
                'bio' => $request->bio,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ]);
            // Give a role
            $role_id = DB::table('roles')->where('name', '=', 'doctor')->first();
            $role_user = DB::table('role_user')->insert([
                'user_id' => $user_id,
                'role_id' => $role_id->id
            ]);
            // insert doctor schedule
            $doctorSchedule = $this->insertWeeksDays($this->getClinic()->id, $user_id);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
        return $user && $doctor && $role_user && $doctorSchedule;
    }

    public function getDoctorRow($id)
    {
        $row = DB::table('users')
            ->join('doctors', 'doctors.user_id', '=', 'users.id')
            ->where('users.id', '=', $id)
            ->where('users.clinic_id', $this->getClinic()->id)
            ->select('users.*', 'users.id as userId', 'doctors.*')
            ->first();
        return $row;
    }

    public function updateDoctor($request, $id)
    {
        $row = $this->getDoctorRow($id);
        $this->validate($request, [
            'name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'string', 'email', 'max:191', 'unique:users,email,' . $row->userId],
            'phone' => ['required', 'numeric', 'digits:11'],
            'title' => ['required', 'string', 'max:191'],
            'degree' => ['required', 'string', 'max:191'],
            'specialist' => ['required', 'string', 'max:191'],
            'slot_time' => ['required', 'numeric'],
            'examination_fees' => ['required', 'numeric'],
            'followup_fees' => ['required', 'numeric'],
            'bio' => ['nullable', 'string'],
            'receptionist' => ['required', 'integer'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048']
        ]);

        if (!empty($row->profile_photo_path) && file_exists(public_path('images/users/' . $row->profile_photo_path))) {
            if ($request->hasFile('image') && $request->file('image')) {
                unlink(public_path('images/users/' . $row->profile_photo_path));
            }
        }
        $this->validate($request, [
            'name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'string'],
            'password' => ['min:8', 'required_with:password_confirmation', 'same:password_confirmation'],
            'password_confirmation' => ['min:8'],
            'phone' => ['required', 'numeric', 'digits:11'],
            'title' => ['required', 'string', 'max:191'],
            'degree' => ['required', 'string', 'max:191'],
            'specialist' => ['required', 'string', 'max:191'],
            'slot_time' => ['required', 'numeric'],
            'examination_fees' => ['required', 'numeric'],
            'followup_fees' => ['required', 'numeric'],
            'bio' => ['nullable', 'string'],
            'receptionist' => ['required', 'integer'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048']
        ]);
        try {
            DB::beginTransaction();
            $user = DB::table('users')
                ->where('id', '=', $id)
                ->where('users.clinic_id', '=', $this->getClinic()->id)
                ->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'profile_photo_path' => ($request->hasFile('image') && $request->file('image') != '' ? $this->storeImage($request) : $row->profile_photo_path),
                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                ]);
            $doctor = DB::table('doctors')
                ->where('user_id', '=', $id)
                ->where('doctors.clinic_id', '=', $this->getClinic()->id)
                ->update([
                    'receptionist_id' => $request->receptionist,
                    'title' => $request->title,
                    'degree' => $request->degree,
                    'specialist' => $request->specialist,
                    'slot_time' => $request->slot_time,
                    'examination_fees' => $request->examination_fees,
                    'followup_fees' => $request->followup_fees,
                    'bio' => $request->bio,
                ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
        return $user || $doctor;
    }

    public function showDoctor($id)
    {
        $row = DB::table('users')
            ->join('doctors', 'doctors.user_id', '=', 'users.id')
            ->where('users.id', '=', $id)
            ->where('users.clinic_id', '=', $this->getClinic()->id)
            ->select('users.*', 'users.id as userId', 'doctors.*')
            ->first();
        $schedule_rows = DB::table('users')
            ->join('doctors', 'doctors.user_id', '=', 'users.id')
            ->join('doctor_schedules', 'doctor_schedules.user_id', '=', 'doctors.user_id')
            ->where('users.clinic_id', '=', $this->getClinic()->id)
            ->where('users.id', '=', $id)
            ->where('doctor_schedules.day_attendance', '=', '1')
            ->orderBy('doctor_schedules.id', 'asc')
            ->select('doctor_schedules.*')
            ->get();
        $appointments_count = DB::table('appointments')
            ->where('clinic_id', '=', $this->getClinic()->id)
            ->where('doctor_id', '=', $id)
            ->count();
        $today_appointments_count = DB::table('appointments')
            ->where('clinic_id', '=', $this->getClinic()->id)
            ->whereDate('date', '=', Carbon::today()->toDateString())
            ->where('doctor_id', '=', $id)
            ->count();
        $tomorrow_appointments_count = DB::table('appointments')
            ->where('clinic_id', '=', $this->getClinic()->id)
            ->whereDate('date', '=', Carbon::tomorrow()->toDateString())
            ->where('appointments.status', '=', 'pending')
            ->where('doctor_id', '=', $id)
            ->count();
        $upcomming_appointments_count = DB::table('appointments')
            ->where('clinic_id', '=', $this->getClinic()->id)
            ->whereDate('date', '>', Carbon::today()->toDateString())
            ->where('appointments.status', '=', 'pending')
            ->where('doctor_id', '=', $id)
            ->count();
        $today_prescriptions_sum = DB::table('prescriptions')
            ->where('clinic_id', '=', $this->getClinic()->id)
            ->whereDate('created_at', '=', Carbon::today()->toDateString())
            ->where('doctor_id', '=', $id)
            ->sum('fees');
        $today_incomes_sum = DB::table('incomes')
            ->where('clinic_id', '=', $this->getClinic()->id)
            ->whereDate('created_at', '=', Carbon::today()->toDateString())
            ->where('doctor_id', '=', $id)
            ->sum('amount');
        $today_sessions_sum = DB::table('sessions_info')
            ->where('clinic_id', '=', $this->getClinic()->id)
            ->whereDate('created_at', '=', Carbon::today()->toDateString())
            ->where('doctor_id', '=', $id)
            ->sum('fees');
        $total_prescriptions_sum = DB::table('prescriptions')
            ->where('clinic_id', '=', $this->getClinic()->id)
            ->where('doctor_id', '=', $id)
            ->sum('fees');
        $total_incomes_sum = DB::table('incomes')
            ->where('clinic_id', '=', $this->getClinic()->id)
            ->where('doctor_id', '=', $id)
            ->sum('amount');
        $total_sessions_sum = DB::table('sessions_info')
            ->where('clinic_id', '=', $this->getClinic()->id)
            ->where('doctor_id', '=', $id)
            ->sum('fees');
        $appointments = DB::table('appointments')
            ->join('users as t2', 't2.id', '=', 'appointments.patient_id')
            ->where('appointments.clinic_id', '=', $this->getClinic()->id)
            ->where('appointments.doctor_id', '=', $id)
            ->whereDate('appointments.date', '=', Carbon::today()->toDateString())
            ->select('appointments.*', 't2.name as patient_name', 't2.phone')
            ->orderBy('appointments.time', 'desc')->get();
        $prescriptions = DB::table('prescriptions')
            ->join('users as t2', 't2.id', '=', 'prescriptions.patient_id')
            ->where('prescriptions.clinic_id', '=', $this->getClinic()->id)
            ->where('prescriptions.doctor_id', '=', $id)
            ->select('prescriptions.*', 't2.name as patient_name')
            ->orderBy('prescriptions.date', 'desc')
            ->get();

        $today_earrings = $today_prescriptions_sum + $today_incomes_sum + $today_sessions_sum;
        $revenue = $total_prescriptions_sum + $total_incomes_sum + $total_sessions_sum;

        $monthly_patients_counts = DB::table('patients')
            ->where('clinic_id', $this->getClinic()->id)
            ->where('doctor_id', auth()->user()->id)
            ->selectRaw('month(created_at) as month')
            ->selectRaw('count(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->take(12)
            ->get();
        $monthly_prescriptions_counts = DB::table('prescriptions')
            ->where('clinic_id', $this->getClinic()->id)
            ->where('doctor_id', auth()->user()->id)
            ->selectRaw('month(created_at) as month')
            ->selectRaw('count(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->take(12)
            ->get();
        $current_month_prescriptions_sum = DB::table('prescriptions')
            ->where('clinic_id', '=', $this->getClinic()->id)
            ->where('doctor_id', '=', auth()->user()->id)
            ->whereMonth('created_at', '=', Carbon::now()->format('m'))
            ->sum('fees');
        $current_month_incomes_sum = DB::table('incomes')
            ->where('clinic_id', '=', $this->getClinic()->id)
            ->where('doctor_id', '=', auth()->user()->id)
            ->whereMonth('created_at', '=', Carbon::now()->format('m'))
            ->sum('amount');
        $current_month_sessions_sum = DB::table('sessions_info')
            ->where('clinic_id', '=', $this->getClinic()->id)
            ->where('doctor_id', '=', auth()->user()->id)
            ->whereMonth('created_at', '=', Carbon::now()->format('m'))
            ->sum('fees');
        $current_monthly_earrings = $current_month_prescriptions_sum + $current_month_incomes_sum + $current_month_sessions_sum;
        $last_month = (Carbon::now()->format('m') - 1) == 0 ? 12 : (Carbon::now()->format('m') - 1);
        $last_month_prescriptions_sum = DB::table('prescriptions')
            ->where('clinic_id', '=', $this->getClinic()->id)
            ->where('doctor_id', '=', auth()->user()->id)
            ->whereMonth('created_at', '=', $last_month)
            ->sum('fees');
        $last_month_incomes_sum = DB::table('incomes')
            ->where('clinic_id', '=', $this->getClinic()->id)
            ->where('doctor_id', '=', auth()->user()->id)
            ->whereMonth('created_at', '=', $last_month)
            ->sum('amount');
        $last_month_sessions_sum = DB::table('sessions_info')
            ->where('clinic_id', '=', $this->getClinic()->id)
            ->where('doctor_id', '=', auth()->user()->id)
            ->whereMonth('created_at', '=', $last_month)
            ->sum('fees');
        $last_monthly_earrings = $last_month_prescriptions_sum + $last_month_incomes_sum + $last_month_sessions_sum;
        $earring_percentage = $last_monthly_earrings != 0 ? (($current_monthly_earrings - $last_monthly_earrings) / $last_monthly_earrings) * 100 : 100;
        return [
            $row,
            $schedule_rows,
            $appointments_count,
            $today_appointments_count,
            $tomorrow_appointments_count,
            $upcomming_appointments_count,
            $today_earrings,
            $earring_percentage,
            $current_monthly_earrings,
            $last_monthly_earrings,
            $revenue,
            $appointments,
            $prescriptions,
            $monthly_patients_counts,
            $monthly_prescriptions_counts,
        ];
    }

    public function updateSchedule($request, $id)
    {
        $row = DB::table('users')
            ->join('doctors', 'doctors.user_id', '=', 'users.id')
            ->join('doctor_schedules', 'doctor_schedules.user_id', '=', 'doctors.user_id')
            ->where('users.clinic_id', '=', $this->getClinic()->id)
            ->where('users.id', '=', $id)
            ->orderBy('doctor_schedules.id', 'asc')
            ->select('users.name as name', 'users.id as userId', 'doctor_schedules.*', 'doctors.title as title', 'doctor_schedules.id as schedule_id')
            ->get();

        for ($i = 0; $i < 7; $i++) {
            // validation
            if (isset($request->day_of_week[$i])) {
                if ($request->first_start_time[$i] == '') {
                    return Redirect::back()->with('error', 'You must fill time of ' . $row[$i]->day_of_week . ' day !');
                }
                if ($request->first_start_time[$i] != '' && $request->first_end_time[$i] == '') {
                    return Redirect::back()->with('error', 'You must complete time "To" time of ' . $row[$i]->day_of_week . ' day !');
                }
                if ($request->first_start_time[$i] > $request->first_end_time[$i]) {
                    return Redirect::back()->with('error', 'The "From" time input value must be lower than "To" time input!');
                }

                if ($request->second_start_time[$i] != '' && $request->second_end_time[$i] == '') {
                    return Redirect::back()->with('error', 'You must complete time "To" time of ' . $row[$i]->day_of_week . ' day !');
                }
                if ($request->second_start_time[$i] > $request->second_end_time[$i]) {
                    return Redirect::back()->with('error', 'The "From" time input value must be lower than "To" time input!');
                }

            }

            $updateSchedule = DB::table('doctor_schedules')
                ->where('id', '=', $row[$i]->schedule_id)
                ->update([
                    'day_attendance' => isset($request->day_of_week[$i]) ? $request->day_of_week[$i] : 0,
                    'first_start_time' => $request->first_start_time[$i],
                    'first_end_time' => $request->first_end_time[$i],
                    'second_start_time' => $request->second_start_time[$i],
                    'second_end_time' => $request->second_end_time[$i],
                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                ]);
        }

        return $updateSchedule;
    }

    protected function storeImage($request)
    {
        $save_path = 'images/users';
        if (!file_exists(public_path($save_path))) {
            mkdir($save_path, 666, true);
        }
        if ($request->file('image')) {
            $file = $request->file('image');
            $image = Image::make($file)->resize(300, 200);
            $filename = time() . str_random(10) . '.' . $file->getClientOriginalExtension();
            $image->save(public_path('images/users/' . $filename));
            return $filename;
        }
    }

    function insertWeeksDays($clinic_id, $doctor_id)
    {
        $weekDaysArray = array('Sat', 'Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri');
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
        if ($doctorSchedule) {
            return true;
        }
    }
}
