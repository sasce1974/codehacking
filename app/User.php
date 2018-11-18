<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role_id', 'is_active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function role(){
        return $this->belongsTo('App\Role');
    }

    public function photos(){
        return $this->hasMany('App\Photo');
    }

    public function posts(){
        return $this->hasMany('App\Post');
    }


    //mutator for password encrypting
    public function setPasswordAttribute($value){
        if(!empty($value)) {
            return $this->attributes['password'] = bcrypt($value);
        }
    }

    public function isAdmin(){
        if($this->role->name == 'Admin' && $this->is_active == 1){
            return true;
        }else{
            return false;
        }
    }

}
