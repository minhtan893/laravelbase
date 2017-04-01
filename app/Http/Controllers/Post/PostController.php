<?php

namespace App\Http\Controllers\Post;

use Intervention\Image\ImageServiceProvider ;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Repositories\PostRepository;
use Validator;
use App\Repositories\CateRepository;
use Auth;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;



/**
 * class làm việc với post
 */
class PostController extends Controller
{
    //
    protected $user;
    protected $post;

    /**
     * khởi tạo 2 repository user và post
     */
    function __construct(){
    	$this->user = new UserRepository;
    	$this->post = new PostRepository;
      $this->cate = new CateRepository;
    } 

    /**
     * create
     *@param int $userId id của user tạo post
     *@return view
     */
  	public function create($userId){
  		if($this->user->findId($userId)){
        $cates = $this->cate->showAll();
  			return view('post.create')->with(['userId'=>$userId , 'cates'=>$cates]);
  		}else{
  			abort(404);
  		}
  	}

  	/**
  	 * hàm lưu mới
  	 *@param int userId id của user tạo post
  	 *@param Request
  	 *@return View | error
  	 */
  	public function store($userId , Request $postRequest){
       
  		 $thumb=null;
            

        if($postRequest->file('thumb')){
            $thumb = $postRequest->file('thumb');
          
            $path = 'upload';
               $fileName = time()."-".$thumb->getClientOriginalName();
               
               $thumb->move($path , $fileName); 
               $thumb = $path."/".$fileName;
        }
        $postId = $this->post->save($postRequest , $thumb);
  		if($postId){
  			return redirect()->route('post.show',$postId);
  		}else{
  			abort(404);
  		}
  	}

  	/**
  	 *show 
  	 */
  	public function show($id){
  		$post = $this->post->findId($id);
  		return view('post.post')->with('post',$post);
  	}

  	/**
     * Show list
  	 */

  	public function index(){
  		$posts = $this->post->postPaginateOrderBy('updated_at', 'DESC', 2 , Auth::user()->id);     
  		return view('post.index')->with('posts', $posts);
  	}

  	/**
  	 *destroy 
  	 */
  	public function destroy($id){
  		 $post = $this->post->findId($id);
        if($post){
            //Xóa file ảnh
            $results  = "";
            //preg_match('/< *img[^>]*src *= *["\']?([^"\']*)/i', $post->content, $matches);
            preg_match_all('/<img[^>]+>/i',$post->content, $results);
            //preg_match('/< *img[^>]*src *= *["\']?([^"\']*)/i', $results[0][2], $src);
              //  var_dump($src[1]);  
                //die();
            foreach ($results[0] as $key => $value) {
                $src = "";
                preg_match('/< *img[^>]*src *= *["\']?([^"\']*)/i', $value, $src);
                $srcDel = trim($src[1],'/');
                $srcDelThumb = str_replace('shares', 'shares/thumbs', $srcDel);
                if(File::exists($srcDel)){
                    File::delete($srcDel); 
                }      
                if(File::exists($srcDelThumb)){
                    File::delete($srcDelThumb);
                }             
            }    
            $disk = Storage::disk('public');
            if($disk->exists($post->thumb) && $post->thumb !=null){
                $disk->delete($post->thumb);
            }
            if($this->post->delete($id)){
                return redirect()->route('post.index')->with('status','Xóa rồi nhé !');
             }else{
                abort(404);
             }   
        }else{
            abort(404);
        }
  	}

  	public function edit($id){
  		$post = $this->post->findId($id);
      $cates = $this->cate->showAll();
  		if($post){
  			return view('post.edit')->with(['post'=>$post, 'cates'=>$cates]);
  		}else{
  			abort(404);
  		}
    }


     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $postRequest, $id)
    {

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
       $year = Carbon::now()->year;
            $month = Carbon::now()->month;
            $day = Carbon::now()->day;
            $disk = Storage::disk('public');
           
            $store = "posts/$year/$month-$year/$day-$month-$year/"; 
          $thumb = \Image::make($postRequest->file('thumb'))->resize(120,120);
          $validate = Validator::make($postRequest->all(),
           ['thumb'=>'mimes:jpeg,jpg,png'],['thumb.mimes'=>'File tải lên phải là định dạng ảnh']);

        if($validate->fails()){
            return redirect()->route('post.edit',$id)->withErrors($validate);
        }
        $fileName = time()."-".$postRequest->file('thumb')->getClientOriginalName();
        File::exists(storage_path('app/public/' . $store)) or File::makeDirectory(storage_path('app/public/' . $store));
        $store .=$fileName; 
          if($disk->exists($post->thumb) && $post->thumb !=null){
            $disk->delete($post->thumb);
          }

            $thumb->save(storage_path('app/public/'.$store.$fileName));
      }
        //Lưu csdl
        $id = $this->post->update($postRequest ,$id ,   $store );
        if($id !=false){
            return redirect()->route('post.show',$id);
        }else{
            abort(404);
        }
 }
}
