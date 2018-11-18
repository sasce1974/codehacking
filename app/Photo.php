<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = ['user_id', 'file'];

    protected $uploads = '/images/';


    public function user(){
        return $this->belongsToMany('App\User');
    }

    public function post(){
        return $this->hasOne('App\User');
    }

    public function getFileAttribute($photo){
        return $this->uploads . $photo;
    }


}
