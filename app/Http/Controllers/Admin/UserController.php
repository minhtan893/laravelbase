<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Repositories\UserRepository;
use App\Http\Controllers\Admin\PostController;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $user ;

     function __construct(UserRepository $user){
        $this->user = $user;
     }

    public function index()
    {
        //
        $users = $this->user->paginateOrderBy("updated_at" , 'DESC' , 10);
        $usersTranfer = $this->user->showAll();
        return view('admin.users')->with(['users' =>$users,'usersTranfer'=>$usersTranfer]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $user = $this->user->findId($id);
        if($user){
            return view('admin.user')->with('user',$user);
        }else{
            abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $user = $this->user->findId($id);
        if($user){
            return view('admin.userUpdate')->with('user',$user);
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
    public function update(Request $userRequest, $id)
    {
        //
        $user = $this->user->findId($id);

        $validate = Validator::make($userRequest->all(),[
                'username'=>'required|max:255|unique:users,username,'.$user->id,
                'email' => 'required|email|unique:users,email,'.$user->id
            ]);
        if($validate->fails()){
            return redirect()->route('user.edit',$user->id)->withErrors($validate);
        }else{
        
            $this->user->save($userRequest , $id);    
            return redirect()->route('user.show',$id);
        }
    }


    /**
     * SHhơ the Del List.
     *
     * 
     * @return view
     */
    public function recycle()
    {
        $user = $this->user->trashed(5);
        return view('admin.recycle')->with('users',$user);
    }   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request , $id)
    {
        //
        $post = new PostController;
        $post->tranfer($id , $request->input('userTranfer'));
        if($this->user->delete($id)){
                return redirect()->route('user.index')->with('status','Xóa rồi nhé !');
            
        }else{
            abort(404);
        }
    }
    public function delete($id){
        if($this->user->forceDel($id)){
            return redirect()->route('admin.recycle')->with('status','Đã xóa vĩnh viễn!');
        }else{
            abort(404);
        }
    }
    /**
     *Restore
    */
    public function restore($id){
       if($this->user->withTrashed($id)){
           return redirect()->route('user.index')->with('status', 'Đã khôi phục User');
       
        }
        else{
           abort(404);
        }
    }
}
