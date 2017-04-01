<?php 

namespace App\Repositories;

use App\Models\User;
use App\Models\Post;
use App\Repositories\RepositoryInterface;
use Illuminate\Http\Request;

class PostRepository implements RepositoryInterface{
	/**
	 * function tìm kiếm post theo ID
	 *@param int $id id của post
	 *@return object
	 */
	public function findId($id){
		return Post::find($id);
	}

	/**
	 * function soft delete post theo ID
	 *@param int $id id của post
	 *@return true|false
	 */
	public function delete($id){
		$post  = Post::find($id);
		if($post->delete($id)){
			return true;
		}
		else{
			return false;
		}
	}


    /**
	 * function xóa post  theo ID
	 *@param int $id id của post
	 *@return object
	 */
    public function forceDel($id){

    }


		/**
		 * function paginateOrderBy
		 *@param string $order sắp xép theo
		 *@param string $rule luật
		 *@param int $limit biến phân trang
		 *@return object  	
		 */	
		public function paginateOrderBy($order , $rule , $limit){
			return Post::orderBy($order , $rule)->paginate($limit);
		}

		/**
		 * function paginateOrderBy
		 *@param string $order sắp xép theo
		 *@param string $rule luật
		 *@param int $limit biến phân trang
		 *@return object  	
		 */	
		public function postPaginateOrderBy($order , $rule , $limit ,$userId){
			$user = User::find($userId);
			$post =  $user->posts()->orderBy($order , $rule)->paginate($limit);
			return $post;	
		}


		/**
         * hàm lưu 
         *@param request input mảng dữ liệu truyền vào để lưu
         *@return true|fale 
		 */
		public function save($input , $optional=null){
			$post = new Post;
			
			$post->title = $input->input('title');
			$post->content = $input->input('content');
			$post->cate_id = $input->input('cateId');
			$post->thumb = $optional;
			$post->user_id = $input->userId;
			if($post->save()){
				return $post->id;
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

			$post = Post::find($id);
			$post->title = $input->input('title');
			$post->content = $input->input('content');
			$post->cate_id = $input->input('cateId');
			if($thumb !=null){
				$post->thumb = $thumb;
			}

			if($post->save()){
				return $post->id;
			}
			else{
				return false;
			}
		}

		public function tranfer($userId , $userTranfer){
			$posts = Post::where('user_id' ,'=',$userId)->get();
			for($i=0;$i<count($posts) ; $i++){
				$posts[$i]->user_id = $userTranfer;
				$posts[$i]->save();
			}
			
		}
		
	}

	?>