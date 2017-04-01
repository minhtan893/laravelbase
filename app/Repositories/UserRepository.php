<?php 
	
namespace App\Repositories;

use App\Repositories\RepositoryInterface;
use App\Models\User;	
use Illuminate\Database\Eloquent\SoftDeletes;


	/**
     * class làm việc với user model
     *
     */

	class UserRepository implements RepositoryInterface{

			/**
	 * function tìm kiếm post theo ID
	 *@param int $id id của post
	 *@return object
	 */
	public function findId($id){
		return User::find($id);
	}

	/**
	 * function soft delete post theo ID
	 *@param int $id id của post
	 *@return true|false
	 */
	public function delete($id){
		  $user = User::find($id);
        if($user){
                $user->delete();
                return true;
            
        }else{
            return false;
        }
	}
    

    /**
	 * function xóa post  theo ID
	 *@param int $id id của post
	 *@return object
	 */
	public function forceDel($id){
		 $user = User::withTrashed()->where('id', '=', $id)->first();
        	if($user){
            	$user->forceDelete();
            	return true;
        	}else{
            	return false;
        }
	}


		/**
		 * function paginateOrderBy
		 *@param string $order sắp xép theo
		 *@param string $rule luật
		 *@param int $limit biến phân trang
		 *@return object  	
		 */	
		public function paginateOrderBy($order , $rule , $limit){
			return User::orderBy($order , $rule)->paginate($limit);
		}


		/**
         * hàm lưu 
         *@param request input mảng dữ liệu truyền vào để lưu
         *@return true|fale 
		 */
		public function save($userRequest , $optional=null){
			$user = User::find($optional);
			
			if($user->fill($userRequest->all())->save()){
				return $user->id;
			}
			else{
				return false;
			}
		}

		/**
         * hàm lưu 
         *@param request input mảng dữ liệu truyền vào để lưu
         *@return true|fale 
		 */
		public function update($input , $id , $thumb){

			$user = User::find($id);

			$user->title = $input->input('title');
			$page->content = $input->input('content');
			if($thumb !=null){
				$page->thumb = $thumb;
			}

			if($page->save()){
				return $page->id;
			}
			else{
				return false;
			}
		}


		/**
         * hàm trashed
		 */
		public function trashed($limit){
			return User::onlyTrashed()->paginate($limit);
		}

		/**
     	 * hàm with trashed
		 */
		public function withTrashed($id){
			$user = User::withTrashed()->where('id', '=', $id)->first();
			 if($user->trashed()){
            	if($user->restore()){
            	return true;
            }
            }	
		}

		public function showAll(){
			return User::all();
		}
	}
?>