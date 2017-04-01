@extends('admin.layout')
@section('title')
&Iota; {{ $page->title }}
@endsection()
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
@section('script')
<script type="text/javascript" src="{{ asset('js/page.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin-page.js') }}"></script>
@endsection
@section('content')
<div class="container wrapper">
	<div class="content">
		<div class="row">
			<h4 class="display-4">{{ $page->title }}</h4>
			<hr>
			<br>
			<div class="col-sm-12 col-md-2">
				@if($page->thumb!=null)
					<img src="{{ asset($page->thumb) }}" alt="Thumb" class="img-fluid" >
				@endif
				<br>
				<h5>Administrator</h5>
				<p><small>Tạo lúc: {{ $page->created_at }}</small></p>
				<a href="{{ route('page.edit',$page->id) }}" class="btn btn-primary btn-sm"><strong>Sửa</strong></a>
				<a href="javascript:;" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delModal"><strong>Xóa</strong></a>
			</div>
			<div class="col-sm-12 col-md-10">
				{!! $page->content !!}

				<div class="col-sm-12 comment-section">
				<hr>
				<?php  $i=0;?>
				@foreach($comments as $comment)
				@if($comment->parent_id == 0 )
				<?php $i++; ?>
				<div class="col-xs-12 first-comment">
					<span>
					@if($comment->deleted_at ==null)
						<strong>{{ $comment->users->name }}</strong>
					@else
						<strong class='text-muted'>{{ $comment->users->name }}</strong>
					@endif	
					</span>
					<small class='text-muted'></small>
					<p>{{ $comment->content }}
					@if($comment->deleted_at==null)
					 <a href="{{ route('admin.comment.delete' , $comment->id) }}">Ẩn</a>
					@else
					<a href="{{ route('admin.comment.restore' , $comment->id) }}">Khôi phục</a>
					@endif
					  <a href="{{ route('admin.comment.forceDel',$comment->id) }}">Xóa</a></p>
					<div class="child-comment col-xs-10 col-offset-2" parent-section='{{ $comment->id}}'>
						<?php  $j=0;?>

						@foreach($comments as $key => $value)
						@if($value->parent_id == $comment->id) 
						<?php $j++; ?>
						<div class="col-xs-12 second"  commentChild-id={{ $value->id }}>
							<span>
							@if($value->deleted_at ==null)
								<strong>{{ $value->users->name }}</strong>
							@else
									<strong class='text-muted'>{{ $value->users->name }}</strong>
							@endif			
							</span>
							<small class='text-muted'></small>
							<p>{{ $value->content }} 
							@if($value->deleted_at ==null)
							<a href="{{ route('admin.comment.delete' , $value->id) }}">Ẩn</a>
							@else
							<a href="{{ route('admin.comment.restore' , $value->id) }}">Khôi phục</a>
							@endif	
							 <a href="{{ route('admin.comment.forceDel',$value->id) }}">Xóa</a></p>
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
			@if($commentParent>5)
			<a href="javascript:;"  id='loadMoreParent'>Thêm</a>
			@endif
			</div>
			<input type="hidden" id="pageId" value="{{ $page->id}}">
		</div>
	</div>
</div>
<div class="modal fade" id="delModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Xác nhận xóa</h4>
			</div>
			<div class="modal-body">
				Xóa "{{ $page->title }}" ?
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<a href="{{route('page.destroy' , $page->id) }}" onclick="event.preventDefault();
					document.getElementById('delete-form').submit();" type="button" class="btn btn-primary">Delete</a>
					{{ Form::open(array('url' => 'admin/page/' . $page->id, 'class' => 'form-control pull-right', 'style'=>'display:hidden','id'=>'delete-form')) }}
					{{ Form::hidden('_method', 'DELETE') }}
					{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
@endsection
<script type="text/javascript">
  var token = "{{ Session::token() }}";
  var url = "{{ route('comment.store')}}";
  var url1 = "{{ route('comment.loadCommentParent')}}";
  var url2 = "{{ route('comment.loadCommentParentMore')}}";
  var url3 = "{{ route('comment.loadCommentChildMore')}}";
</script>
