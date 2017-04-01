<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\CateRepository;
use Illuminate\Support\Facades\Validator;

/**
 * Class Quản lý category
 * 
 */
class CateController extends Controller
{
    //
	protected $cate ;

	function __construct(){
		$this->cate = new CateRepository;
	}

    /**
     *hàm hiển thị tất cả danh mục
     *@return  view  
    */
    public function index(){
        $cates = $this->cate->showAll();
        return view('admin.cates.index')->with('cates', $cates);    
    }

    public function showCate(){
        $cates = $this->cate->showAll();
        return view('cate')->with('cates', $cates);    
    }

     /**
     *hàm hiển thị tất cả danh mục
     *@return  view  
    */
    public function manage(){
        $cates = $this->cate->showAll();
        return view('admin.cates.manage')->with('cates', $cates);   
    } 

    /**
     *hàm hiển thị tất cả danh mục
     *@return  view  
    */
    public function add(){
    	$cates = $this->cate->showAll();
    	return view('admin.cates.add')->with('cates', $cates);	
 	}

    /**
     *lưu danh mục mới  
     */
    public function save(Request $cateRequest){
        $validate = Validator::make($cateRequest->all(),[
                'title'=>'required|unique:cates'
            ]);
        if($validate->fails()){
            return redirect()->route('admin.cate.add')->withErrors($validate);
        }else{
            if($this->cate->save($cateRequest)){
                return redirect()->route('admin.cate.manage')->with('status', 'Đã thêm mới danh mục');
            }
        }
    }  

    /**
     *chỉnh sửa
     */ 
    public function edit($id){
        $cate = $this->cate->findId($id);
        $cates = $this->cate->showAll();
        return view('admin.cates.edit')->with(['cate'=>$cate  , 'cates'=>$cates]);
    } 

    /**
     *update
     */ 
    public function update(Request $cateRequest ,$id){
        $cate = $this->cate->findId($id);
        $validate = Validator::make($cateRequest->all(),[
                'title' => 'required|unique:cates,title,'.$cate->id
            ]);
        if($validate->fails()){
                abort(404);
           
        }
        else{
                 if($this->cate->update($cateRequest , $id ,null)){
                return redirect()->route('admin.cate.manage')->with('staus', 'Đã cập nhật danh mục!');
            }else{
                abort(404);
            }
           }
    }

    /**
     *delete
     */ 
    public function delete($id){
        if($this->cate->delete($id)){
                return redirect()->route('admin.cate.manage')->with('staus', 'Đã xóa danh mục!');
            }else{
                abort(404);
            }
         }   
}
