<?php 
	
	namespace App\Repositories;

	use Illuminate\Database\Eloquent\SoftDeletes;
	use App\Models\Comment;
	use App\Repositories\RepositoryInterface;
	use Auth;
	
	class commentRepository implements RepositoryInterface{
	/**
	 * function tìm kiếm comment theo ID
	 *@param int $id id của comment
	 *@return object
	 */
	public function findId($id){
		return Comment::find($id);
	}

	/**
	 * function soft delete comment theo ID
	 *@param int $id id của comment
	 *@return true|false
	 */
	public function delete($id){
		$comment  = Comment::find($id);
		$comment->delete();
	}
    
    /**
	 *Xóa post theo danh mục
    */

    public static function delPost($id){

    	$comment = Comment::find($id);
    	$comment->posts()->delete();
    }			

	/**
	 * Show all
	 */
	public function showAll(){
		return Comment::orderBy('created_at' ,'DESC');
	}


    /**
	 * function xóa comment  theo ID
	 *@param int $id id của comment
	 *@return object
	 */
	public function forceDel($id){
		 $comment = Comment::withTrashed()->where('id' , '=' , $id)->first();
         $comment->forceDelete();
	}


		/**
		 * function paginateOrderBy
		 *@param string $order sắp xép theo
		 *@param string $rule luật
		 *@param int $limit biến phân trang
		 *@return object  	
		 */	
		public function paginateOrderBy($order , $rule , $limit){
			return Comment::orderBy($order , $rule)->paginate($limit);
		}

		/**
		 * function paginateOrderBy
		 *@param string $order sắp xép theo
		 *@param string $rule luật
		 *@param int $limit biến phân trang
		 *@return object  	
		 */	
		public function commentPaginateOrderBy($order , $rule , $limit ,$userId){
			$user = Comment::find($userId);
			$comment =  $user->comments()->orderBy($order , $rule)->paginate($limit);
			return $comment;	
		}


		/**
         * hàm lưu 
         *@param request input mảng dữ liệu truyền vào để lưu
         *@return true|fale 
		 */
		public function save($input , $optional=null){
			$comment = new Comment;
			$comment->content = $input->input('content');
			$comment->parent_id = $input->input('parentId');
			$comment->user_id = Auth::user()->id;
			
			if($optional == true){
				$comment->post_id = null;
				$comment->page_id = $input->input('pageId');
			}
			else{
				$comment->post_id = $input->input('postId');
				$comment->page_id = null;
			}
			if($comment->save()){
				return $comment;
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

			
		}


		/**
		 * hàm restore comment
		 */
		public function restore($id){
			$comment = Comment::withTrashed()->where('id','=',$id)->first();
			$comment->restore();
		}
		
	}

?>