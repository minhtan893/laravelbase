<?php 
	
	namespace App\Repositories;

	use App\Models\Cate;
	use App\Repositories\RepositoryInterface;

	class CateRepository implements RepositoryInterface{
	/**
	 * function tìm kiếm cate theo ID
	 *@param int $id id của cate
	 *@return object
	 */
	public function findId($id){
		return Cate::find($id);
	}

	/**
	 * function soft delete cate theo ID
	 *@param int $id id của cate
	 *@return true|false
	 */
	public function delete($id){
		$cate  = Cate::find($id);
		$cates = Cate::All();
		function del($id , $cates){

			foreach ($cates as $key ) {
				if($key->parent_id == $id){
					del($key->id, $cates);
					Self::delPost($$key->id);
					$key->delete();
				}
			}
		}
		if($cate){
				del($cate->id , $cates);
				$cate->delete();
				return true;
			}
		else{
			return false;
		}
	}
    
    /**
	 *Xóa post theo danh mục
    */

    public static function delPost($id){
    	$cate = Cate::find($id);
    	$cate->posts()->delete();
    }			

	/**
	 * Show all
	 */
	public function showAll(){
		return Cate::all();
	}
    /**
	 * function xóa cate  theo ID
	 *@param int $id id của cate
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
			return Cate::orderBy($order , $rule)->paginate($limit);
		}

		/**
		 * function paginateOrderBy
		 *@param string $order sắp xép theo
		 *@param string $rule luật
		 *@param int $limit biến phân trang
		 *@return object  	
		 */	
		public function catePaginateOrderBy($order , $rule , $limit ,$userId){
			$user = Cate::find($userId);
			$cate =  $user->cates()->orderBy($order , $rule)->paginate($limit);
			return $cate;	
		}


		/**
         * hàm lưu 
         *@param request input mảng dữ liệu truyền vào để lưu
         *@return true|fale 
		 */
		public function save($input , $optional=null){
			$cate = new Cate;
			
			$cate->title = $input->input('title');
			$cate->parent_id = $input->parentId;
			if($cate->save()){
				return true;
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

			$cate = Cate::find($id);
			$cate->title = $input->input('title');
			$cate->parent_id  = $input->input('parentId');
			
			if($cate->save()){
				return $cate->id;
			}
			else{
				return false;
			}
		}
		
	}

?>