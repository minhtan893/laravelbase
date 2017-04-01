<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\CateRepository;
use App\Repositories\PostRepository;
use App\Repositories\CommentRepository;

class CateController extends Controller
{
    //

	protected $cate;
  protected $post;
  protected $comment;

	function __construct(){
    $this->cate = new CateRepository;
		$this->post = new PostRepository;
    $this->comment = new CommentRepository;
	}
    /**
     * show post
     */
    public function index(){
    	$cates = $this->cate->showAll();
    	return view('cate.index')->with('cates',$cates);
    }

    public function show($id){
   		$cate = $this->cate->findId($id);
      $cates  = $this->cate->showAll();
   		if($cate){
        $posts = $cate->posts()->orderBy('updated_at','DESC')->paginate(2);
   			return view('cate.cateShow')->with(['cate'=>$cate, 'posts'=>$posts , 'cates'=>$cates]);
   		}
   		else{
   			abort(404);
   		}
    }

    public function showPost($id){
      $cate = $this->cate->showAll();
      $post= $this->post->findId($id);
      $comment = $post->comments->all();
      $commentParent = $post->comments->where('parent_id' , '=' , 0);
      return view('cate.showPost')->with(['cate'=>$cate  ,'post'=> $post , 'comments'=>$comment, 'commentParent'=>$commentParent->count()]);
    }
}
