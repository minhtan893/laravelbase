<?php

namespace App\Http\Controllers\Admin;

	use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\CommentRepository;

class CommentController extends Controller
{
    //
    protected $comment;

    function __construct(){
    	$this->comment = new CommentRepository;
    }

    public function delete($id){
    	$this->comment->delete($id);
    	return redirect()->back();
    }

    public function forceDel($id){
    	$this->comment->forceDel($id);
    	return redirect()->back();
    }

    public function restore($id){
        $this->comment->restore($id);
        return redirect()->back();
    }

}
