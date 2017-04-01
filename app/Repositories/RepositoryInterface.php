<?php 
	namespace App\Repositories;
		
	interface RepositoryInterface{

		public function findId($id);

		public function delete($id);

		public function forceDel($id);

		public function paginateOrderBy($order , $rule , $limit);

		public function save($input , $optional=null);

		public function update($input , $id , $thumb);

	}	
?>