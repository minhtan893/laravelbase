<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\CommentRepository;
use App\Repositories\PageRepository;
use Illuminate\Http\Response;
use Auth;
use App\Models\Comment;
use App\Repositories\PostRepository;

/**
 * Class Comment
 */
class CommentController extends Controller
{
    //
  protected $comment ;
  protected $page ;
	protected $post ;
	function __construct(){
    $this->comment = new CommentRepository;
    $this->page = new PageRepository;
		$this->post = new PostRepository;
	}

    /**
  	 * Submit comment	
     */
    public function store(Request $comment){
      
    	$rs['status'] = null;
        if($comment->input('postId') == ""){
    	     $comment = $this->comment->save($comment , true);
         }else{
           $comment = $this->comment->save($comment , null);
         }
    	if($comment){
    		$rs['content'] = $comment->content;
    		$rs['user'] = $comment->users->name;
    		$rs['id'] = $comment->id;
    		$rs['created_at'] = $comment->created_at;
    		$rs['parentId'] = $comment->parent_id;
    	}
    	else{
    		$rs['status'] = false;
    	}

    	return response()->json($rs);
    }


    /**
     *load trang đầu tiên
     */
    public function getCommentParent(Request $request){
      if($request->input('postId') ==""){
        $page = $this->page->findId($request->input('pageId'));
        $comments = $page->comments->where('id', '>' , $request->input('start'))->all();
      }else{
         $post = $this->post->findId($request->input('postId'));
        $comments = $post->comments->where('id', '>' , $request->input('start'))->all();
      }
        
        $i = 0;
        $arrSum = [];
        foreach ($comments as $comment) {
            $arr = [];
          if($comment->parent_id == 0){
            $i++;
            $arr['id'] = $comment->id;
            $arr['content'] = $comment->content;
            $arr['user'] = $comment->users->name;
            $arr['user_id'] = $comment->user_id;
            $arr['created_at'] = $comment->created_at;
            $arr['deleted_at'] = $comment-deleted_at;
            $arr['child'] = null;
            $j = 0;
            foreach ($comments as $key => $value) {
                if($value->parent_id == $comment->id){
                  $j++;
                  $tmpArr = [];
                  $tmpArr['id'] = $value->id;
                  $tmpArr['content'] = $value->content;
                  $tmpArr['user'] = $value->users->name;
                  $tmpArr['user_id'] = $value->user_id;
                  $tmpArr['created_at'] = $value->created_at;
                  $tmpArr['deleted_at'] = $value->deleted_at;
                  $arr['child'] = $tmpArr;
                }
                if($j==2){
                  break;
                }
            }
            array_push($arrSum , $arr);
          }
          if($i==10){
            break;
          }
        }
        return response()->json($arrSum);
    }


    public function getCommentParentMore(Request $request){
      if($request->input('postId') !=""){
          $post = $this->post->findId($request->input(('postId')));
         $comments = $post->comments->where('parent_id' , '=' , $request->input('parentId'));
      }else{
         $page = $this->page->findId($request->input(('pageId')));
         $comments = $page->comments->where('parent_id' , '=' , $request->input('parentId'));
      }
     
      
      return  response()->json(['count'=>$comments->count()]);
    }

    public function getCommentChildMore(Request $request){
      $start = (int)$request->input('start');
      if($request->input('pageId')){
        $page = $this->page->findId($request->input(('pageId')));
         $comments = $page->comments->where('parent_id' , '=' , $request->input('parentId'))->where('id' , '>' ,$start)->take(20);
      }else{
        $post = $this->post->findId($request->input(('postId')));
         $comments = $post->comments->where('parent_id' , '=' , $request->input('parentId'))->where('id' , '>' ,$start)->take(20);
      }

     
      $arrSum = [];
       foreach ($comments as $key) {
                  $tmpArr = [];
                  $tmpArr['id'] = $key->id;
                  $tmpArr['content'] = $key->content;
                  $tmpArr['user'] = $key->users->name;
                  $tmpArr['user_id'] = $key->user_id;
                  $tmpArr['created_at'] = $key->created_at;
                  $tmpArr['deleted_at'] = $key->deleted_at;
            array_push($arrSum , $tmpArr);
       }
      return  response()->json($arrSum);
    }
}
