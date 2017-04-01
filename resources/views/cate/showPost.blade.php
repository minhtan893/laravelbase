@extends('main')
@section('title')
&Iota; {{ $post->title }}
@endsection()
@section('nav-item')
<li class="nav-item ">
  <a class="nav-link" href="/" >Home</a>
</li>
<li class="nav-item">
  <a class="nav-link" href="{{ route('cate.index') }}">Danh mục</a>
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
<script type="text/javascript" src="{{ asset('js/page.js') }}"></script>
<script type="text/javascript" src='{{ asset('js/comment.js') }}'></script>
@endsection
@section('content')

<div class="container wrapper">
  <div class="content">
    <div class="col-xs-12">
      <h5 class="display-5">{{ $post->title }}</h5>
      <p>by <a href="javascript:;">{{$post->users->name }}</a></p>
      <hr>
      <input type="hidden" name="postId" value="{{ $post->id}}" id='postId'>
    </div>
    <div class="col-xs-12">
      <p>Posted on : {{ $post->created_at}}</p>
      <hr>
      
    </div>

    <div class="col-sm-12 col-md-12 main">
      {!! $post->content !!}
    </div>
    <div class="col-xs-12 xs-offset-1">
      @if(Auth::user())
      <form action="javascript:; " method="POST" class='comment-form'>
        {{ csrf_field() }}
        <input type="hidden" name="comment_parent" value='0'>
        <input type="hidden" name="userId" value='{{ Auth::user()->id}}'>
        <input type="hidden" name="postId" value='{{ $post->id}}'>
        <div class="form-group">
          <label><h5>Comment</h5></label>
          <textarea class="form-control" rows="4" required name="content" id="textarea"></textarea> 
        </div>
        <button class="btn btn-primary" id="comment-form-button" >Comment</button>
      </form>
      @else
      <p>Đăng nhập để bình luận</p>
      @endif 
    </div>   
  </div>

  <div class="col-sm-12 comment-section">
   <hr>
   <?php  $i=0;?>
   @foreach($comments as $comment)
   @if($comment->parent_id == 0 )
   <?php $i++; ?>
   <div class="col-xs-12 first-comment">
    <span>
      <strong>{{ $comment->users->name }}</strong>
    </span>
    <small class='text-muted'></small>
    <p>{{ $comment->content }}<a href="javascript:;" class='comment-button' comment-Id="{{ $comment->id}}"> Trả lời</a></p>
    <div class="child-comment col-xs-10 col-offset-2" parent-section='{{ $comment->id}}'>

      <?php  $j=0;?>

      @foreach($comments as $key => $value)
      @if($value->parent_id == $comment->id) 
      <?php $j++; ?>
      <div class="col-xs-12 second"  commentChild-id={{ $value->id }}>
       <span>
         <strong>{{ $value->users->name }}</strong>
       </span>
       <small class='text-muted'></small>
       <p>{{ $value->content }}</p>
     </div>
     <?php unset($comments[$key]); ?>
     @endif
     <?php if($j==2){break;} ?>

     @endforeach
   </div>
 </div>
 @endif
 <?php if($i==5){ echo "<input type='hidden' value='".$comment->id."' id='start'>";   break;} ?>
 @endforeach
</div>
</div>
@if($commentParent>5)
<div class="col-xs-12">
<a href="javascript:;"  id='loadMoreParent'>Thêm</a>
</div>
@endif
@endsection
<script type="text/javascript">
  var token = "{{ Session::token() }}";
  var url = "{{ route('comment.store')}}";
  var url1 = "{{ route('comment.loadCommentParent')}}";
  var url2 = "{{ route('comment.loadCommentParentMore')}}";
  var url3 = "{{ route('comment.loadCommentChildMore')}}";
</script>

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