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

<div class="container wrapper">
  <div class="content">
   <div class="row">
    <h4 class="display-4">{{ $cate->title}}</h4>
     @foreach($posts as $post)
     <div class="row title" style="margin-top:30px;">
      <div class="col-xs-12 col-sm-2">
      @if($post->thumb !=null)
        <img src="{{ asset($post->thumb)}}" alt="" style="height: 140px; width:100px; ">
        @endif
      </div>
      <div class="col-xs-12 col-sm-10">
        <a href="{{ route('admin.post.show',$post->id) }}"><h4 class="display-5">{{ $post->title }}</h4></a>
        <?php 
        $sort = explode(" ", strip_tags($post->content));
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
        <footer class="blockquote-footer">Cập nhật lúc :{{ $post->updated_at }} bởi: {{$post->users->name }}
		<span>
			<a href="{{ route('admin.post.delete',$post->id) }}" class="btn btn-danger btn-sm">Xóa</a>
			<a href="{{  route('admin.post.edit',$post->id)}}" class="btn btn-info btn-sm">Sửa</a>
		</span>
        </footer>
      </div>
    </div>
    @endforeach
  </div>
  {{ $posts->links('pagination') }}
</div>
</div>
@endsection