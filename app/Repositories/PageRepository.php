<?php 
namespace App\Repositories;

use App\Models\Page;
use App\Repositories\RepositoryInterface;

	

	/**
     * class làm việc với post model
     *
	 */
	class PageRepository implements RepositoryInterface {
		/**
	 * function tìm kiếm post theo ID
	 *@param int $id id của post
	 *@return object
	 */
	public function findId($id){
		return Page::find($id);
	}

	/**
	 * function soft delete post theo ID
	 *@param int $id id của post
	 *@return true|false
	 */
	public function delete($id){
		
	}
    

    /**
	 * function xóa post  theo ID
	 *@param int $id id của post
	 *@return object
	 */
	public function forceDel($id){
		$page  = Page::find($id);
		if($page->delete($id)){
			return true;
		}
		else{
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
			return Page::orderBy($order , $rule)->paginate($limit);
		}


		/**
         * hàm lưu 
         *@param request input mảng dữ liệu truyền vào để lưu
         *@return true|fale 
		 */
		public function save($input , $optional=null){
			$page = new Page;
			
			$page->title = $input->input('title');
			$page->content = $input->input('content');
			$page->thumb = $optional;
			if($page->save()){
				return $page->id;
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

			$page = Page::find($id);

			$page->title = $input->input('title');
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
	}
	?>