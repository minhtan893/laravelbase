<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    //
    use SoftDeletes;
    
    protected $table = 'comments';
    public function posts(){
    	return $this->belongsTo('App\Models\Post' , 'post_id');
    }

    public function users(){
    	return $this->belongsTo('App\Models\User','user_id');
    }


    public function pages(){
    	return $this->belongsTo('App\Models\Page','page_id');
    }

}
