@extends('admin.layout')
@section('nav-item')
<li class="nav-item active">
	<a class="nav-link" href="{{ route('admin.pages') }}" >Pages<span class="sr-only">(current)</span></a>
</li>
<li class="nav-item dropdown ">
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
@section('title','| Edit Page')
@section('script')
<script src="{{ asset('js/lfm.js')}}"></script>
<script type='text/javascript' src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
<script type='text/javascript' src="{{ asset('js/editPage.js') }}"></script>

@endsection
@section('content')
<div class="container">
	<div class="content">
	<h2 class="display-4 align-center">Sửa bài</h2>
		<hr>
		{{ Form::model($page , ['route'=>['page.update',$page->id] , 'method'=>'PATCH', 'enctype'=>'multipart/form-data' ,'novalidate']) }}
				{{ csrf_field() }}
			<div class="form-group row">
				<label for="title" class="col-xs-2 col-form-label">Tiêu đề</label>
				<div class="col-xs-10">
					<input class="form-control" type="text" id="title" placeholder="Title" name='title' required value="{{ $page->title }}">
				</div>
				  @if($errors->has('title'))
                        <small id="help-block" class="form-text text-muted">{{ $errors->first('title') }}</small>
				@endif
			</div>
			<div class="form-group row">
				<div class="col-xs-2">
				@if($page->thumb!=null)
				<img src="{{ asset('storage/'.$page->thumb) }}" alt="" class="img-fluid">
				@endif
				</div>
			</div>
			<div class="form-group row">
				<label for="thumb" class="col-xs-2 col-form-label">Ảnh đại diện</label>
				<div class="col-xs-10">
					<input type="file" name="thumb" class="form-group" accept="images/*">
				</div>
				  @if($errors->has('thumb'))
                        <small id="help-block" class="form-text text-muted">{{ $errors->first('thumb') }}</small>
					@endif
			</div>
			
			<div class="form-group row">
				<label for="content" class="col-xs-2 col-form-label">Nội dung</label>
				<div class="col-xs-12">
					<textarea name="content" id="content" required>{{ $page->content }}</textarea>
				</div>
			</div>
			<br>
			<button type='submit' class='btn btn-success btn-lg'>Cập nhật</button>
		<!-- </form> -->
		{{ Form::close() }}
	</div>
</div>
<script>
</script>
@endsection