<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    public function create(){
        return view('prescriptions.create');
    }

    public function show(){
        return view('prescriptions.show');
    }
}
