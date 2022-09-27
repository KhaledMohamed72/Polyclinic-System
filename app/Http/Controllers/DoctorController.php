<?php

namespace App\Http\Controllers;


use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{

    public function index()
    {
        $rows = DB::table('users')
            ->join('doctors', 'doctors.user_id', '=', 'users.id')
            ->join('role_user', 'role_user.user_id', '=', 'doctors.user_id')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->where('users.clinic_id', '=', $this->getClinic()->id)
            ->select('users.*', 'doctors.title')
            ->paginate(10);
        return view('doctors.index', compact('rows'));
    }

    public function create()
    {
        // check if the clinic is single or multiple doctors
        $doctors = Doctor::all()->count();
        if ($this->getClinic()->type == 0 && $doctors < 1) {
            return view('doctors.create');
        } elseif ($this->getClinic()->type == 1) {
            return view('doctors.create');
        } else {
            toastr()->warning('You can just add one doctor');
            return redirect()->route('doctors.index');
        }
    }

    public function store(Request $request)
    {
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
        }else{
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
        return view('doctors.edit', compact('row'));
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
            'email' => ['required', 'string', 'email', 'max:191', 'unique:users,email,'.$row->userId],
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
            $user = DB::table('users')->where('id','=',$id)->update([
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
            $user = DB::table('users')->where('id','=',$id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ]);
        }

        if ($request->hasFile('image') && !(isset($request->password) && $request->password != "")) {
            $user = DB::table('users')->where('id','=',$id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'profile_photo_path' => $this->storeImage($request),
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ]);
        }

        if (!$request->hasFile('image') && (isset($request->password) && $request->password != "")) {
            $user = DB::table('users')->where('id','=',$id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ]);
        }
        $doctor = DB::table('doctors')->where('user_id','=',$id)->update([
            'title' => $request->title,
            'degree' => $request->degree,
            'specialist' => $request->specialist,
            'slot_time' => $request->slot_time,
            'fees' => $request->fees,
            'bio' => $request->bio,
        ]);
        if ($user && $doctor){
            toastr()->success('Successfully Updated');
            return redirect()->route('doctors.index');
        }else{
            toastr()->error('Something went wrong!');
            return redirect()->route('doctors.index');
        }

    }

    public function destroy($id){
        $user = User::where('id','=',$id)->delete();
        if ($user){
            toastr()->success('Successfully Deleted');
            return redirect()->route('doctors.index');
        }else{
            toastr()->error('Something went wrong!');
            return redirect()->route('doctors.index');
        }
    }
}
