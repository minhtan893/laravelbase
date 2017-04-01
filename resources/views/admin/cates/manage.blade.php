@extends('admin.layout')
@section('nav-item')	
<li class="nav-item ">
	<a class="nav-link" href="{{ route('admin.pages') }}" >Pages<span class="sr-only">(current)</span></a>
</li>
<li class="nav-item dropdown active">
						<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="route('admin.cate.index')" role="button" aria-haspopup="true" aria-expanded="false">
							Danh mục
						</a>
						<div class="dropdown-menu" aria-labelledby="Preview">
							<a class="dropdown-item" href="{{ route('admin.cate.index') }}">Tất cả danh mục</a>
							<a class="dropdown-item" href="{{ route('admin.cate.manage') }}" >Quản lý danh mục</a>
							
						</div>
					</li>
	<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="route('user.index')" role="button" aria-haspopup="true" aria-expanded="false">
							User
						</a>
						<div class="dropdown-menu" aria-labelledby="Preview">
							<a class="dropdown-item" href="{{ route('user.index') }}">List</a>
							<a class="dropdown-item" href="{{ route('admin.recycle') }}" >Recycle</a>
							
						</div>
					</li>
@endsection
@section('title','| Categories')
@section('script')

@endsection
@section('content')
<div class="container">
	<div class="content" style="margin-top: 40px;">
		<div class="row">
			<div class="col-xs-12">
				<a href="{{ route('admin.cate.add')}}" class="float-xs-right">Thêm danh mục</a>
				<br>
				@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
				<table class="table  table-inverse">
					<tbody>
					{{  cate($cates) }}
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<script>
</script>
@endsection
<?php 
	function cate($cates , $parentId=0 , $char =""){
		foreach ($cates as $cate) 
		{
			if($cate->parent_id == $parentId){
				
				echo "<tr><td><a href=''>".$char.$cate->title."</a></td><td><a href='".route('admin.cate.delete',$cate->id)."' class='btn btn-danger btn-sm'>Xóa</a> <a href='".route('admin.cate.edit',$cate->id)."' class='btn btn-info btn-sm'>Sửa</a></td></tr>";
				cate($cates , $cate->id, $char."--");
			}
		}
	}

?>