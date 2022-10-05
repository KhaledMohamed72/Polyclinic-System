<?php

namespace App\Http\Controllers;


use App\Models\Doctor;
use App\Models\Receptionist;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{

    public function index()
    {
        // check if the clinic is single or multiple doctors
        $doctors = Doctor::all()->count();
        $clinicType = $this->getClinic()->type;
        // filter doctors according to role of current auth user
        if (auth()->user()->hasRole('admin')) {
            $rows = DB::table('users')
                ->join('doctors', 'doctors.user_id', '=', 'users.id')
                ->join('role_user', 'role_user.user_id', '=', 'doctors.user_id')
                ->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->where('users.clinic_id', '=', $this->getClinic()->id)
                ->select('users.*', 'doctors.title')
                ->paginate(10);
        } else {
            $rows = DB::table('users')
                ->join('doctors', 'doctors.user_id', '=', 'users.id')
                ->join('role_user', 'role_user.user_id', '=', 'doctors.user_id')
                ->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->where('users.clinic_id', '=', $this->getClinic()->id)
                ->where('doctors.receptionist_id', '=', auth()->user()->id)
                ->select('users.*', 'doctors.title')
                ->paginate(10);
        }
        if (auth()->user()->hasRole(['admin', 'recep'])) {
            return view('doctors.index', compact('rows','clinicType','doctors'));
        } else {
            toastr()->error('Something went wrong!');
            return redirect()->route('home');
        }
    }

    public function create()
    {
        // check if the clinic is single or multiple doctors
        $doctors = Doctor::all()->count();
        $receptionist = Receptionist::all()->count();
        $receptionists_rows = DB::table('users')
            ->join('receptionists', 'receptionists.user_id', '=', 'users.id')
            ->join('role_user', 'role_user.user_id', '=', 'receptionists.user_id')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->where('users.clinic_id', '=', $this->getClinic()->id)
            ->select('users.id', 'users.name')
            ->get();
        // if single
        if ($this->getClinic()->type == 0 && $doctors < 1) {
            if (auth()->user()->hasRole('admin')) {
                // check if clinic has receptionist (According to system flow you must add receptionist before adding doctors
                if ($receptionist >= 1) {
                    return view('doctors.create', compact('receptionists_rows'));
                } else {
                    toastr()->warning('Oops! There is no receptionist. You must first add a receptionist!');
                    return redirect()->route('receptionists.create');
                }

            } else {
                toastr()->warning('Something went wrong!');
                return redirect()->route('doctors.index');
            }
            //if multiple
        } elseif ($this->getClinic()->type == 1) {
            if (auth()->user()->hasRole('admin')) {
                // check if clinic has receptionist (According to system flow you must add receptionist before adding doctors
                if ($receptionist >= 1) {
                    return view('doctors.create', compact('receptionists_rows'));
                } else {
                    toastr()->warning('Oops! There is no receptionist. You must first add a receptionist!');
                    return redirect()->route('receptionists.create');
                }
            } else {
                toastr()->warning('Something went wrong!');
                return redirect()->route('doctors.index');
            }
        } else {
            toastr()->warning('You can just add one doctor');
            return redirect()->route('doctors.index');
        }
    }

    public function store(Request $request)
    {
        if (!auth()->user()->hasRole('admin')) {
            toastr()->warning('Something went wrong!');
            return redirect()->route('doctors.index');
        }
        $this->validate($request, [
            'name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'string', 'email', 'max:191', 'unique:users'],
            'password' => ['min:8', 'required_with:password_confirmation', 'same:password_confirmation'],
            'password_confirmation' => ['min:8'],
            'phone' => ['required', 'numeric', 'digits:11'],
            'title' => ['required', 'string', 'max:191'],
            'degree' => ['required', 'string', 'max:191'],
            'specialist' => ['required', 'string', 'max:191'],
            'slot_time' => ['required', 'numeric'],
            'fees' => ['required', 'numeric'],
            'bio' => ['nullable', 'string'],
            'receptionist' => ['required', 'integer'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048']
        ]);
        // insert general info into users table
        $user = DB::table('users')->insert([
            'clinic_id' => $this->getClinic()->id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
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
            'fees' => $request->fees,
            'bio' => $request->bio,
        ]);

        // Give a role
        $role_id = DB::table('roles')->where('name', '=', 'doctor')->first();
        $role_user = DB::table('role_user')->insert([
            'user_id' => $user_id,
            'role_id' => $role_id->id
        ]);
        if ($user && $doctor && $role_user) {
            toastr()->success('Successfully Created');
            return redirect()->route('doctors.index');
        } else {
            toastr()->error('Something went wrong!');
            return redirect()->route('doctors.index');
        }
    }

    public function edit($id, Request $request)
    {
        $row = DB::table('users')
            ->join('doctors', 'doctors.user_id', '=', 'users.id')
            ->where('users.id', '=', $id)
            ->select('users.*', 'users.id as userId', 'doctors.*')
            ->first();
        $receptionists_rows = DB::table('users')
            ->join('receptionists', 'receptionists.user_id', '=', 'users.id')
            ->join('role_user', 'role_user.user_id', '=', 'receptionists.user_id')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->where('users.clinic_id', '=', $this->getClinic()->id)
            ->select('users.id', 'users.name')
            ->get();

        if (auth()->user()->hasRole('admin')) {
            return view('doctors.edit', compact('row', 'receptionists_rows'));
        } else {
            toastr()->warning('Something went wrong!');
            return redirect()->route('doctors.index');
        }

    }

    public function update(Request $request, $id)
    {
        $row = DB::table('users')
            ->join('doctors', 'doctors.user_id', '=', 'users.id')
            ->where('users.id', '=', $id)
            ->select('users.*', 'users.id as userId', 'doctors.*')
            ->first();
        $this->validate($request, [
            'name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'string', 'email', 'max:191', 'unique:users,email,' . $row->userId],
            'password' => ['nullable', 'min:8', 'required_with:password_confirmation', 'same:password_confirmation'],
            'password_confirmation' => ['nullable', 'min:8'],
            'phone' => ['required', 'numeric', 'digits:11'],
            'title' => ['required', 'string', 'max:191'],
            'degree' => ['required', 'string', 'max:191'],
            'specialist' => ['required', 'string', 'max:191'],
            'slot_time' => ['required', 'numeric'],
            'fees' => ['required', 'numeric'],
            'bio' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048']
        ]);

        if ($request->hasFile('image') && (isset($request->password) && $request->password != "")) {
            if (!empty($row->profile_photo_path)) {
                unlink(public_path('images/users/' . $row->profile_photo_path));
            }
            $user = DB::table('users')->where('id', '=', $id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'profile_photo_path' => $this->storeImage($request),
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ]);
        }
        if (!$request->hasFile('image') && !(isset($request->password) && $request->password != "")) {
            $user = DB::table('users')->where('id', '=', $id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ]);
        }
        if ($request->hasFile('image') && !(isset($request->password) && $request->password != "")) {
            if (!empty($row->profile_photo_path)) {
                unlink(public_path('images/users/' . $row->profile_photo_path));
            }
            $user = DB::table('users')->where('id', '=', $id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'profile_photo_path' => $this->storeImage($request),
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ]);
        }
        if (!$request->hasFile('image') && (isset($request->password) && $request->password != "")) {
            $user = DB::table('users')->where('id', '=', $id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ]);
        }
        $doctor = DB::table('doctors')->where('user_id', '=', $id)->update([
            'title' => $request->title,
            'degree' => $request->degree,
            'specialist' => $request->specialist,
            'slot_time' => $request->slot_time,
            'fees' => $request->fees,
            'bio' => $request->bio,
        ]);
        if ($user || $doctor) {
            toastr()->success('Successfully Updated');
            return redirect()->route('doctors.index');
        } else {
            toastr()->error('Something went wrong!');
            return redirect()->route('doctors.index');
        }

    }

    public function destroy($id)
    {
        $user = User::where('id', '=', $id)->first();
        if (auth()->user()->hasRole('admin')) {
            if (!empty($user->profile_photo_path)) {
                unlink(public_path('images/users/' . $user->profile_photo_path));
            }
            $user = $user->delete();
        } else {
            toastr()->warning('You can not delete doctor !');
            return redirect()->route('doctors.index');
        }
        if ($user) {
            toastr()->success('Successfully Deleted');
            return redirect()->route('doctors.index');
        } else {
            toastr()->error('Something went wrong!');
            return redirect()->route('doctors.index');
        }
    }

    public function show($id)
    {
        $row = DB::table('users')
            ->join('doctors', 'doctors.user_id', '=', 'users.id')
            ->where('users.id', '=', $id)
            ->select('users.*', 'users.id as userId', 'doctors.*')
            ->first();

        if ($row) {
            if (auth()->user()->hasRole(['admin', 'recep'])) {
                return view('doctors.show', compact('row'));
            } else {
                toastr()->warning('You can not allowed for this route !');
                return redirect()->route('doctors.index');
            }
        } else {
            toastr()->error('Something went wrong!');
            return redirect()->route('doctors.index');
        }
    }

    public function scheduleCreate($id){
        $row = DB::table('users')
            ->join('doctors','doctors.user_id','=','users.id')
            ->join('doctor_schedules','doctor_schedules.user_id','=','doctors.user_id')
            ->where('users.clinic_id','=',$this->getClinic()->id)
            ->where('users.id','=',$id)
            ->select('users.name as name','users.id as userId','doctor_schedules.*')
            ->get();
        $userId = $id;
        return view('doctors.schedule-create',compact('row','userId'));
    }

    public function scheduleStore($id){

    }
}
