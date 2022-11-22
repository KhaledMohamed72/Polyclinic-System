<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function changePassword()
    {
        if (auth()->user()->hasRole(['admin', 'doctor', 'recep'])) {
            return view('auth.change-password');
        }
    }

    public function updatePassword(Request $request)
    {
        # Validation
        $request->validate([
            'new_password' => 'required|confirmed', 'required_with:password_confirmation', 'same:password_confirmation',
        ]);


        #Update the new Password
        $row = DB::table('users')
            ->where('id', auth()->user()->id)
            ->where('clinic_id', $this->getClinic()->id)
            ->update([
                'password' => bcrypt($request->new_password),
            ]);
        if ($row) {
            toastr()->success('Updated Successfully');
            return redirect()->route('logout');
        }else{
            toastr()->error('Something went wrong');
            return redirect()->route('home');
        }
    }
}
