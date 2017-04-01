<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cate extends Model
{
    //
	protected $table = 'cates';
	
    public function posts(){
    	return $this->hasMany('App\Models\Post');
    }
}
