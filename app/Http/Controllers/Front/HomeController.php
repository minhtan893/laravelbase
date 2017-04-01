<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Repositories\PageRepository;
use App\Repositories\CommentRepository;
use App\Repositories\CateRepository;

class HomeController extends Controller
{

    protected $page;
    protected $commens;
    protected $cate;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(PageRepository $page)
    {
        //$this->middleware('auth');
        $this->page = $page;
        $this->comments = new CommentRepository;
        $this->cate = new CateRepository;

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $cate=$this->cate->showAll(); 
        $pages = $this->page->paginateOrderBy('created_at' , 'DESC' , 10);
         return view('index')->with(['pages'=> $pages, 'cate'=>$cate]);
    }

    public function show($id){
        $page = $this->page->findId($id);
        $comment = $page->comments->all();
        $cate=$this->cate->showAll(); 
        $commentParent = $page->comments->where('parent_id' , '=' , 0);
       if($page){
            return view('page')->with(['page'=>$page, 'comments'=>$comment, 'cate'=>$cate , 'commentParent'=>$commentParent->count()]);
        }else{
            abort(404);
        }
    }
}
