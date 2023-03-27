<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//plante 
use App\Models\Plante;
//users 
use App\Models\User;

class Category extends Model
{
    use HasFactory;
    //fillable 
    protected $fillable = [
        'name',
    ];

    //
    public function plantes(){
        return $this->hasMany(Plante::class);
    }
    public function users(){
        //belongs 
        return $this->belongsToMany(User::class);
    }
}
