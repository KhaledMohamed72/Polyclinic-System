<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    use HasFactory;
    protected $fillable = ['name','domain','phone','active','type'];
    public function users(){
        return $this->hasMany(User::class);
    }

}
