@extends('main')
@section('nav-item')
<li class="nav-item">
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

          <li class="nav-item "><a href="{{route('login')}}" class="nav-link">Đăng nhập</a></li> 
          <li class="nav-item active"><a href="{{route('register')}}" class="nav-link">Đăng ký</a></li>
          @endif  
@endsection
@section('content')
<div class="container content">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <h2 class="display-4">Register</h2>
                <div class="panel-body" style="margin-top:30px;">
                  
                <form method="post" action="{{route('register')}}">
                    {{ csrf_field() }}
                      <div class="form-group">
                            <label for="name">Họ tên</label>
                            <input type="text" class="form-control" id='name' name='name' placeholder=" Nhập họ tên">
                      </div>

                      <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name='username' aria-describedby="emailHelp" placeholder="Nhập username">
                        @if($errors->has('username'))
                        <small id="help-block" class="form-text text-muted">{{ $errors->first('username') }}</small>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name='email' placeholder="Nhập email"> 
                         @if($errors->has('email'))
                        <small class="form-text text-muted">{{ $errors->first('email') }}</small>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id='password' name='password' placeholder="Nhập password">
                         @if($errors->has('password'))
                        <small class="form-text text-muted">{{ $errors->first('password') }}</small>
                        @endif
                  </div>

                  <div class="form-group">
                    <label for="password_confirmation">Xác nhận password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Xác nhận password">
              </div>
              <button type="submit" class="btn btn-primary">Đăng ký</button>
  
            </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
