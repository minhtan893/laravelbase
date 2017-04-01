@extends('main')

@section('title', '| Trang chủ')
@section('nav-item')
      <li class="nav-item active">
          <a class="nav-link" href="/" >Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('cate.index')}}">Danh mục</a>
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
              <a class="dropdown-item" href="{{ route('user.profile',Auth::user()->id) }}">Profile</a>
  @else
             <a class="dropdown-item" href="{{ route('user.profile',Auth::user()->id) }}">Profile</a>
              <a class="dropdown-item" href="{{ route('post.index') }}">Posts</a>
              <a class="dropdown-item" href="{{ route('post.create',Auth::user()->id) }}">Viết bài</a>
              @endif
              
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
@section('content')
<div class="container">
  <h4 class="display-3 content">Pages</h4>
  <hr>
  
  @foreach($pages as $page)
  <div class="row title" style="margin-top:30px;">
    <div class="col-xs-12 col-sm-2">
      @if($page->thumb !=null)
      <img src="{{ asset($page->thumb)}}">
      @else
        <img src="{{ asset('default.jpg') }}">
      @endif
    </div>
    <div class="col-xs-12 col-sm-10">
      <a href="{{ route('front.page.show',$page->id) }}"><h4 class="display-5">{{ $page->title }}</h4></a>
      <?php 
      $sort = explode(" ", strip_tags($page->content));
      $sortContent = [];
      if(count($sort) > 30){
        for ($i=0; $i < 30; $i++) { 
          array_push($sortContent, $sort[$i]);
        }
      }
      else{
        for ($i=0; $i < count($sort); $i++) { 
          array_push($sortContent, $sort[$i]);
        }
      }
      ?>
      <p style="width:80%">{!! implode(" ",$sortContent)!!}...</p>
      <footer class="blockquote-footer">Created at :{{ $page->created_at }}</footer>
    </div>
  </div>
  @endforeach
  <br>
<div class="align-center">{{ $pages->links('pagination') }}</div>
</div>
@endsection

@section('cate')
<div class="col-xs-12 ">
  <h4>Danh mục</h4>
  @foreach($cate as $key)
  <div class="col-xs-6">
    <a href="{{ route('cate.show' , $key->id) }}" >{{ $key->title }}</a>
    </div>
  @endforeach
</div>
@endsection
