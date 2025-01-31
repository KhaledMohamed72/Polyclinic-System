<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Receptionist;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class ReceptionistController extends Controller
{
    public function index()
    {
        // check if the clinic is single or multiple receptionist
        $receptionists = Receptionist::all()->count();
        $clinicType = $this->getClinic()->type;
        $rows = DB::table('users')
            ->join('receptionists', 'receptionists.user_id', '=', 'users.id')
            ->where('users.clinic_id', '=', $this->getClinic()->id)
            ->select('users.*')
            ->orderBy('id','desc')
            ->paginate(10);
        if (auth()->user()->hasRole('admin')) {
            return view('receptionists.index', compact('rows','clinicType','receptionists'));
        }else{
            toastr()->error(trans('main_trans.something_went_wrong'));
            return redirect()->route('home');
        }
    }

    public function create()
    {
        // get doctor of current clinic
        $doctors = DB::table('users')
            ->join('doctors', 'doctors.user_id', '=', 'users.id')
            ->where('users.clinic_id', '=', $this->getClinic()->id)
            ->select('users.id','users.name')
            ->get();
        // check if the clinic is single or multiple
        $receptionists = Receptionist::all()->count();
        // if single
        if ($this->getClinic()->type == 0 && $receptionists < 1) {
            if(auth()->user()->hasRole('admin')) {
                return view('receptionists.create',compact('doctors'));
            }else{
                toastr()->warning(trans('main_trans.something_went_wrong'));
                return redirect()->route('receptionists.index');
            }
            // if multiple
        } elseif ($this->getClinic()->type == 1) {
            if(auth()->user()->hasRole('admin')) {
                return view('receptionists.create',compact('doctors'));
            }else{
                toastr()->warning(trans('main_trans.something_went_wrong'));
                return redirect()->route('receptionists.index');
            }
        } else {
            toastr()->warning('You can just add one Receptionist');
            return redirect()->route('receptionists.index');
        }
    }

    public function store(Request $request)
    {
        if(!auth()->user()->hasRole('admin')) {
            toastr()->warning(trans('main_trans.something_went_wrong'));
            return redirect()->route('home');
        }
        $this->validate($request, [
            'name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'string', 'email', 'max:191', 'unique:users'],
            'phone' => ['required', 'numeric', 'digits:11'],
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
            $receptionist = DB::table('receptionists')->insert([
                'clinic_id' => $this->getClinic()->id,
                'user_id' => $user_id,
            ]);
            // Give a role
            $role_id = DB::table('roles')->where('name', '=', 'recep')->first();
            $role_user = DB::table('role_user')->insert([
                'user_id' => $user_id,
                'role_id' => $role_id->id
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
        if ($user && $receptionist && $role_user) {
            toastr()->success(trans('main_trans.successfully_created'));
            return redirect()->route('receptionists.index');
        }else{
            toastr()->error(trans('main_trans.something_went_wrong'));
            return redirect()->route('receptionists.index');
        }
    }

    public function edit($id, Request $request)
    {
        $row = DB::table('users')
/*            ->join('doctors', 'receptionists.user_id', '=', 'users.id')*/
            ->where('users.id', '=', $id)
            ->select('users.*', 'users.id as userId')
            ->first();

        if(auth()->user()->hasRole('admin')) {
            return view('receptionists.edit', compact('row'));
        }else{
            toastr()->warning(trans('main_trans.something_went_wrong'));
            return redirect()->route('receptionists.index');
        }

    }

    public function update(Request $request, $id)
    {
        $row = DB::table('users')
            ->where('users.id', '=', $id)
            ->select('users.*', 'users.id as userId')
            ->first();
        $this->validate($request, [
            'name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'string', 'email', 'max:191', 'unique:users,email,'.$row->userId],
            'phone' => ['required', 'numeric', 'digits:11'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048']
        ]);

        if (!empty($row->profile_photo_path) && file_exists(public_path('images/users/' . $row->profile_photo_path))) {
            if ($request->hasFile('image') && $request->file('image')){
                unlink(public_path('images/users/' . $row->profile_photo_path));
            }
        }
        $user = DB::table('users')
            ->where('id', '=', $id)
            ->where('users.clinic_id', '=', $this->getClinic()->id)
            ->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'profile_photo_path' =>  ($request->hasFile('image') && $request->file('image') != '' ? $this->storeImage($request) : $row->profile_photo_path),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ]);

        if ($user){
            toastr()->success(trans('main_trans.successfully_updated'));
            return redirect()->route('receptionists.index');
        }else{
            toastr()->error(trans('main_trans.something_went_wrong'));
            return redirect()->route('receptionists.index');
        }

    }

    public function destroy($id){
        $user = User::where('id','=',$id)->first();
        if(!empty($user->profile_photo_path)){
            unlink(public_path('images/users/' . $user->profile_photo_path));
        }
        $user = $user->delete();
        if ($user){
            toastr()->success(trans('main_trans.successfully_deleted'));
            return redirect()->route('receptionists.index');
        }else{
            toastr()->error(trans('main_trans.something_went_wrong'));
            return redirect()->route('receptionists.index');
        }
    }

    public function show($id){
        $row = DB::table('users')
/*            ->join('doctors', 'receptionists.user_id', '=', 'users.id')*/
            ->where('users.id', '=', $id)
            ->select('users.*')
            ->first();
        $doctors = DB::table('users')
            ->join('doctors', 'doctors.user_id', '=', 'users.id')
            ->where('users.clinic_id', '=', $this->getClinic()->id)
            ->where('doctors.receptionist_id', '=', $id)
            ->select('users.*')
            ->get();

        $appointments_count = DB::table('appointments')
            ->where('clinic_id',$this->getClinic()->id)
            ->where('receptionist_id',$id)
            ->count();
        $prescriptions_count = DB::table('prescriptions')
            ->join('doctors','doctors.user_id','=','prescriptions.doctor_id')
            ->where('doctors.receptionist_id',$id)
            ->where('prescriptions.clinic_id',$this->getClinic()->id)
            ->count();
        $sessions_count = DB::table('sessions_info')
            ->join('doctors','doctors.user_id','=','sessions_info.doctor_id')
            ->where('doctors.receptionist_id',$id)
            ->where('sessions_info.clinic_id',$this->getClinic()->id)
            ->count();
        $appointments = DB::table('appointments')
            ->join('users as t1', 't1.id', '=', 'appointments.doctor_id')
            ->join('users as t2', 't2.id', '=', 'appointments.patient_id')
            ->where('appointments.clinic_id', '=', $this->getClinic()->id)
            ->where('appointments.receptionist_id', '=', auth()->user()->id)
            ->select('appointments.*', 't1.name as doctor_name', 't2.name as patient_name', 't2.phone')
            ->orderBy('appointments.id', 'desc')->get();
        $prescriptions = DB::table('prescriptions')
            ->join('users as t1', 't1.id', '=', 'prescriptions.patient_id')
            ->join('patients as t2','t2.user_id','=','t1.id')
            ->join('doctors as t3', 't3.user_id', '=', 't2.doctor_id')
            ->where('t3.receptionist_id','=',$id)
            ->where('prescriptions.clinic_id', '=', $this->getClinic()->id)
            ->select('prescriptions.*', 't1.name as patient_name')
            ->orderBy('prescriptions.date', 'desc')
            ->get();

        if ($row) {
            if (auth()->user()->hasRole(['admin', 'recep','doctor'])) {
                return view('receptionists.show', compact(
                    'row',
                    'doctors',
                    'appointments',
                    'appointments_count',
                    'sessions_count',
                    'prescriptions_count',
                    'prescriptions'
                ));
            } else {
                toastr()->warning('You are not allowed for this route !');
                return redirect()->route('patients.index');
            }
        } else {
            toastr()->error(trans('main_trans.something_went_wrong'));
            return redirect()->route('patients.index');
        }

        if ($row) {
            if(auth()->user()->hasRole('admin')) {
                return view('receptionists.show', compact('row'));
            }else{
                toastr()->warning(trans('main_trans.something_went_wrong'));
                return redirect()->route('home');
            }
        }else{
            toastr()->error(trans('main_trans.something_went_wrong'));
            return redirect()->route('receptionists.index');
        }
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
}
