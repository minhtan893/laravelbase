<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Auth;
use App\Repositories\UserRepository;
/**
 *@author nguyenminhtan<nguyenminhtan893@gmail.com>
 * class sử lý user
 */
class UserController extends Controller
{

    protected $user;
    function __construct(){
        $this->user = new UserRepository;
    }
    /**
      * hàm login bằng username hoặc email  
     */
    public function login(Request $request){

        //Kiểm tra email hay username
        $name  = $request->input('name');
        if(preg_match('/[@]/', $name)){//email

            if(Auth::attempt(['email' => $name,'password' => $request->input('password')])){
                return redirect()->route('home');
            }
            else{
                return redirect()->route('login')->withErrors(['login'=>'Tên đăng nhập (email) hoặc mật khẩu nhập không đúng!']);
            }
        }else{///username

            if(Auth::attempt(['username' => $name,'password' => $request->input('password')])){
            return redirect()->route('home');
        }
        else{
            return redirect()->route('login')->withErrors(['login'=>'Tên đăng nhập (email) hoặc mật khẩu nhập không đúng!']);
        }

    }

}


    /**
     * hàm hiển thị profile user
    */
    public function profile($id){

    	//kiểm tra id có tồn tại không
    	$user = $this->user->findId($id);
    	if($user != null){
    		return view('profile')->with('user',$user);
    	}
    	else{
    		abort(404);
    	}
    }

    /**
     * hàm update profile user
    */
    public function update($id){

    	//kiểm tra id có tồn tại không
    	$user = user::find($id);
    	if($user != null){
    		return view('profile_update')->with('user',$user);
    	}
    	else{
    		abort(404);
    	}
    } 

    /**
     * hàm save profile user
    */
    public function save($id  ,Request $request){

    	//kiểm tra id có tồn tại không

    	$user = user::find($id);
    	if($user != null){
    		$validate =  Validator::make($request->all(), [
              'name' => 'required|max:255',
              'sex'=>'required'
              ]);

    		if($validate->fails()){
    			return redirect()->route('user.update',$user->id)->withErrors($validate);
    		}else{
    			$user->name= $request->input('name');
                if($request->birthday!=null){
    			$user->birthday= $request->input('birthday');}
    			$user->address= $request->input('address');
    			$user->slogan= $request->input('slogan');
    			$user->sex= $request->input('sex');
    			if($user->save()){
    				return redirect()->route('user.profile',$user->id);
    			}else{
    				abort(404);
    			}
    		}
    	}
    	else{
    		abort(404);
    	}
    }


}
