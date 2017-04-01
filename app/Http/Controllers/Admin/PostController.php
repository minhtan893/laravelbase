<?php

namespace App\Http\Controllers\Admin;

use Intervention\Image\ImageServiceProvider ;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\CateRepository;
use App\Repositories\PostRepository;
use Validator;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Repositories\CommentRepository;


class PostController extends Controller
{
    //
    protected $post;
    protected $cate;
    protected $comment;

    function __construct(){
    	$this->post = new PostRepository;
        $this->cate = new CateRepository;
    	$this->comment = new CommentRepository;
    }

    /**
     * show post trong danh mục
    */
    public function index($id){
    	$cate = $this->cate->findId($id);
    	$posts = $cate->posts()->orderBy('updated_at', 'DESC')->paginate(2);
    	return view('admin.post.index')->with(['cate'=>$cate, 'posts'=>$posts]);
    }

    /**
	 *Xóa post
    */
    public function delete($id ){
    	$post = $this->post->findId($id);
    	if($this->post->delete($id)){
    		return redirect()->route('admin.post.index' , $post->cateId)->with('status','đã xóa post!');
    	}else{
    		abort(404);
    	}
    }

    /**
     *Show
    */
    public function show($id){
        $post = $this->post->findId($id);
         $comment = $post->comments()->withTrashed()->get();
        $commentParent = $post->comments()->withTrashed()->where('parent_id' , '=' , 0);
        return view('admin.post.show')->with(['post'=>$post , 'comments'=>$comment , 'commentParent'=>$commentParent->count()]);
    } 

    /**
     *edit
    */
    public function edit($id){
        $post = $this->post->findId($id);
        $cates = $this->cate->showAll();
        return view('admin.post.edit')->with(['post'=>$post, 'cates'=>$cates]);
    }

    /**
     *update
    */
    public function update(Request $postRequest, $id){
        $post = $this->post->findId($id);
        $validate = Validator::make($postRequest->all(),[
           'title'=>'required|max:255' 
           ],['title.required'=>'Title không được trống']);

        if($validate->fails()){
            return redirect()->route('post.edit',$id)->withErrors($validate);
        }
        $store = null;
        $thumb=null;
          //lưu ảnh thumbnail
        if($postRequest->file('thumb')){
             $thumb = $pageRequest->file('thumb');
            $validate = Validator::make($postRequest->all(),
             ['thumb'=>'mimes:jpeg,jpg,png'],['thumb.mimes'=>'File tải lên phải là định dạng ảnh']);

            if($validate->fails()){
                return redirect()->route('post.edit',$id)->withErrors($validate);
            }
            if($disk->exists($post->thumb) && $post->thumb !=null){
                $disk->delete($post->thumb);
            }
            $path = 'upload';
               $fileName = time()."-".$thumb->getClientOriginalName();
               if(File::exists($post->thumb)){
               File::delete($post->thumb);}
               $thumb->move($path , $fileName); 
               $thumb = $path."/".$fileName;
        }
        //Lưu csdl
        $id = $this->post->update($postRequest ,$id ,  $thumb );
        if($id !=false){
            return redirect()->route('admin.post.show',$id);
        }else{
            abort(404);
        }
    }

    public function tranfer($userId , $userTranfer){
        $this->post->tranfer($userId , $userTranfer);
    }
}
