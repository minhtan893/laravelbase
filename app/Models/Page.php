<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    //
    protected $table = 'pages';

    public function comments(){
    	return $this->hasMany('App\Models\Comment');
    }
}
