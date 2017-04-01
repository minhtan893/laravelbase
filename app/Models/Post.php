<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    protected $table = 'posts';
    
    
    public function users(){
    	return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function cates(){
    	return $this->belongsTo('App\Models\Cate' , 'cate_id');
    } 

     public function comments(){
    	return $this->hasMany('App\Models\Comment');
    }
}
