@extends('main')
@section('title', "| Bài Viết")
@section('nav-item')
 <li class="nav-item ">
          <a class="nav-link" href="/" >Home</a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="{{ route('cate.index') }}">Danh mục</a>
          </li>
          <li class="nav-item dropdown">
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

@endsection
@section('content')
<div class="container">
	<div class="content">
	<h2 class="display-3 align-center">Posts</h2>
	<hr>
	  @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
	<div class="pages">
			{{ cate($cates ,0 , " ") }}
		</div>
	</div>
</div>
@endsection
<?php 
	function cate($cates , $parentId=0 , $char =""){
		foreach ($cates as $cate) 
		{
			if($cate->parent_id == $parentId){
			if($cate->posts->count()>0){
				echo "<li class='list-group-item'><a href='".route('cate.show' ,$cate->id)."'>".$cate->title."(".$cate->posts->count().")</a></li>";
			}else{
					echo "<li class='list-group-item'><a href='javascript:;'>".$cate->title."(".$cate->posts->count().")</a></li>";
			}
				cate($cates , $cate->id, $char."--");

			}
			}
		
	}

?>