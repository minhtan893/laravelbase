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
			<div class="col-sm-2 col-xs-12">
				<ul class='list-group'>
					{{ cate($cates) }}
				</ul>
			</div>
			<div class="col-sm-8 col-xs-12">
				
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
				if($cate->posts->count()){
				echo "<li class='list-group-item'><span><a href='".route('admin.post.index',$cate->id)."'>".$char.$cate->title."(".$cate->posts->count().")</a> </span></li>";
			}else{
				echo "<li class='list-group-item'><span><a href='jacascript:;	'>".$char.$cate->title."</a> </span></li>";

			}
				cate($cates , $cate->id, $char."--");
			}
		}
	}

?>