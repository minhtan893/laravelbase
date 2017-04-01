<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use Auth;

/**
 * lớp làm việc với admin
*/
class AdminController extends Controller
{

	/**
     * hàm hiển thị danh sách các post
     *@return view của trng admin
	*/
    public function index(Request $request){
    	return redirect()->route('page.index');
    }

    /**
     *show login
     */
    public function showLogin(){
    	return view('admin.login');
    }


    /**
      * hàm login bằng username hoặc email  
     */
    public function submitLogin(Request $request){

        //Kiểm tra email hay username
        $name  = $request->input('name');
        if(preg_match('/[@]/', $name)){//email

            if(Auth::attempt(['email' => $name,'password' => $request->input('password')])){
                return redirect()->route('home');
            }
            else{
                return view('admin.login')->withErrors(['login'=>'Tên đăng nhập (email) hoặc mật khẩu nhập không đúng!']);
            }
        }else{///username

            if(Auth::attempt(['username' => $name,'password' => $request->input('password')])){
            return redirect()->route('admin.pages');
        }
        else{
            return view('admin.login')->withErrors(['login'=>'Tên đăng nhập (email) hoặc mật khẩu nhập không đúng!']);
        }

    }

}

}
