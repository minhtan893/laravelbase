<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Input;
use Intervention\Image\ImageServiceProvider ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use Validator;
use App\Repositories\PageRepository;
use Carbon\Carbon;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;
use Illuminate\Support\Facades\Storage;
use App\Repositories\CommentRepository;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Comment;

class PageController extends Controller
{

       protected $page;
       protected $comment;

       function __construct(PageRepository $page){
            $this->page = $page;
            $this->comment = new CommentRepository;
       } 


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $pages = $this->page->paginateOrderBy('created_at' ,'DESC', 10);
        return view('admin.index')->with('pages', $pages );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.addPage');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $pageRequest)
    {
            //Kiểm tra title
        $validate = Validator::make($pageRequest->all(),[
         'title'=>'required|max:255' 
         ],['title.required'=>'Title không được trống']);

        if($validate->fails()){
            return redirect()->intended('admin/page/create')->withErrors($validate);
        }

        $thumb=null;
        $store = null;
          //lưu ảnh thumbnail
        if($pageRequest->file('thumb')){

            $thumb = $pageRequest->file('thumb');
           // $thumb = \Image::make($pageRequest->file('thumb'))->resize(120,120);
            $validate = Validator::make($pageRequest->all(),
               ['thumb'=>'mimes:jpeg,jpg,png'],['thumb.mimes'=>'File tải lên phải là định dạng ảnh']);

            if($validate->fails()){
                return redirect()->intended('admin/page/create')->withErrors($validate);
            }
              $path = 'upload';
               $fileName = time()."-".$thumb->getClientOriginalName();
               $thumb->move($path , $fileName); 
               $thumb = $path."/".$fileName;
        }

        //Lưu csdl
        $page = $this->page->save($pageRequest ,$thumb);
        if($page!=false){
            return redirect()->route('page.show',$page);
        }
        else{
            abort(404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $page  = $this->page->findId($id);
        $comment = $page->comments()->withTrashed()->get();
        $commentParent = $page->comments->where('parent_id' , '=' , 0);
        return view('admin.page')->with(['page'=>$page, 'comments'=>$comment , 'commentParent'=>$commentParent->count()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //check id
        $page = $this->page->findId($id);
        if($page){
         return view('admin.editPage')->with('page', $page);
     }
     else{
        abort(404);        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $pageRequest, $id)
    {
     $page = $this->page->findId($id);
     $validate = Validator::make($pageRequest->all(),[
         'title'=>'required|max:255' 
         ],['title.required'=>'Title không được trống']);

     if($validate->fails()){
        return redirect()->route('page.edit',$id)->withErrors($validate);
    }

          $thumb=null;
        $store = null;

          //lưu ảnh thumbnail
    if($pageRequest->file('thumb')){
       
        $validate = Validator::make($pageRequest->all(),
           ['thumb'=>'mimes:jpeg,jpg,png'],['thumb.mimes'=>'File tải lên phải là định dạng ảnh']);

        if($validate->fails()){
            return redirect()->route('page.edit',$id)->withErrors($validate);
        }
       // $fileName = time()."-".$pageRequest->file('thumb')->getClientOriginalName();
         $thumb = $pageRequest->file('thumb');
                $validate = Validator::make($pageRequest->all(),
                     ['thumb'=>'mimes:jpeg,jpg,png'],['thumb.mimes'=>'File tải lên phải là định dạng ảnh']);

                if($validate->fails()){
                        return redirect()->route('post.edit',$id)->withErrors($validate);
               }
               $path = 'upload';    
               $fileName = time()."-".$thumb->getClientOriginalName();
               if(File::exists($page->thumb)){
               File::delete($page->thumb);}
               $thumb->move($path , $fileName); 
               $thumb = $path."/".$fileName;
      }
        //Lưu csdl
        $id = $this->page->update($pageRequest ,$id ,  $thumb );
        if($id !=false){
            return redirect()->route('page.show',$id);
        }else{
            abort(404);
        }
 }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $page = $this->page->findId($id);
        if($page){
            //Xóa file ảnh
            $results  = "";
            //preg_match('/< *img[^>]*src *= *["\']?([^"\']*)/i', $post->content, $matches);
            preg_match_all('/<img[^>]+>/i',$page->content, $results);
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
            if(File::exists($page->thumb)){
                File::delete($page->thumb);
            }
            if($this->page->forceDel($id)){
                return redirect()->route('page.index')->with('status','Xóa rồi nhé !');
             }else{
                abort(404);
             }   
        }else{
            abort(404);
        }
    }


    
}
