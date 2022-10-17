<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        return redirect()->route('home');
    }

    public function logout(){

        auth()->guard('web')->logout();

            return redirect()->route('login');
    }
}
