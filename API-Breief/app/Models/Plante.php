<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//model category 
use App\Models\Category;
//model users 
use App\Models\User;


class Plante extends Model
{
    use HasFactory;
    //fillable 
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'category_id',
        'user_id'
    ];
    
    //relation one to many
    public function category(){
        return $this->belongsTo(Category::class);
    }
    //relation one to many
    public function user(){
        return $this->belongsTo(User::class);
    }

}
