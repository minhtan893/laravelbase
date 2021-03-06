@extends('main')
@section('title', "| Viết bài")
@section('nav-item')
 <li class="nav-item ">
          <a class="nav-link" href="/" >Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('cate.index')}}">Danh mục</a>
          </li>
          <li class="nav-item dropdown active">
          @if(Auth::check())
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
              @if(Auth::user()->level==0)
              Admin
              @else
              {{ Auth::user()->name}}
              @endif
            </a>
            <div class="dropdown-menu" aria-labelledby="Preview">
            @if(Auth::user()->level==0)
              <a href="{{ route('admin.pages')}}" class="dropdown-item">Trang quản trị</a>
              @endif
              <a class="dropdown-item" href="{{ route('user.profile',Auth::user()->id) }}">Profile</a>
              <a class="dropdown-item" href="{{ route('post.index',Auth::user()->id) }}">Posts</a>
              <a class="dropdown-item" href="{{ route('post.create',Auth::user()->id) }}">Viết bài</a>
              <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
              document.getElementById('logout-form').submit();">Đăng xuất</a>
              <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
              </form>
            </div>

          </li>
                    @else

          <li class="nav-item"><a href="{{route('login')}}" class="nav-link">Đăng nhập</a></li> 
          <li class="nav-item"><a href="{{route('register')}}" class="nav-link">Đăng ký</a></li>
          @endif  
@endsection
@section('script')
<script src="{{ asset('js/lfm.js')}}"></script>
<script type='text/javascript' src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
<script type='text/javascript' src="{{ asset('js/admin.js') }}"></script>

@endsection
@section('content')
<div class="container">
	<div class="content">
	<h2 class="display-4 align-center">New Post</h2>
		<hr>
		<form action="{{ route('post.store', $userId) }}" method='POST' enctype="multipart/form-data" novalidate>
			
				{{ csrf_field() }}
				<input type="hidden" name="userId" value="{{ $userId}}">
			<div class="form-group row">
				<label for="title" class="col-xs-2 col-form-label">Tiêu đề</label>
				<div class="col-xs-10">
					<input class="form-control" type="text" id="title" placeholder="Title" name='title' required>
				</div>
				</div>
			<div class="form-group row">	
				<label for="title" class="col-xs-2 col-form-label">Danh mục</label>
				<div class="col-xs-10">
					<select name="cateId" class="form-control">
						{{  cate($cates) }}
					</select>
				</div>
				  @if($errors->has('title'))
                        <small id="help-block" class="form-text text-muted">{{ $errors->first('title') }}</small>
				@endif
			</div>
			<div class="form-group row">
				<label for="thumb" class="col-xs-2 col-form-label">Ảnh đại diện</label>
				<div class="col-xs-10">
					<input class="form-control" type="file"  id="thumb" name="thumb"  accept="image/*">
				</div>
				  @if($errors->has('thumb'))
                        <small id="help-block" class="form-text text-muted">{{ $errors->first('thumb') }}</small>
					@endif
			</div>
			
			<div class="form-group row">
				<label for="content" class="col-xs-2 col-form-label">Nội dung</label>
				<div class="col-xs-12">
					<textarea name="content" id="content" required></textarea>
				</div>
			</div>
			<br>
			<button type='submit' class='btn btn-success btn-lg'>Create</button>
		</form>
	</div>
</div>
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