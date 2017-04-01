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
@section('title','| Thêm danh mục')
@section('script')

@endsection
@section('content')
<div class="container">
	<div class="content" style="margin-top: 40px;">
		<div class="row">
			<div class="col-xs-12">
		<form action="{{ route('admin.cate.add')}}" method="post">
				{{ csrf_field() }}	
				<div class='form-group'>
					<label>Tên danh mục</label>
					<input type="text" class="form-control" name='title'>
					@if($errors->has('title'))
                        <small id="help-block" class="form-text text-muted">{{ $errors->first('title') }}</small>
                        @endif
				</div>
				<div class="form-group">
					<label> Danh mục cha</label>
					<select name="parentId" class="form-control">
						<option value="0">--</option>
						{{  cate($cates) }}
					</select>
				</div>
				<button class='btn btn-success' type='submit'>Thêm mới</button>
				</form>
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
				
				echo "<option value='".$cate->id."'>".$char.$cate->title."</option>";
				cate($cates , $cate->id, $char."--");
			}
		}
	}

?>