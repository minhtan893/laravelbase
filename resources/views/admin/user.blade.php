@extends('admin.layout')
@section('title')
| {{$user->name}}
@endsection
@section('nav-item')
<li class="nav-item ">
	<a class="nav-link" href="{{ route('admin.pages') }}" >Pages</a>
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
	<li class="nav-item dropdown active">
						<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="route('user.index')" role="button" aria-haspopup="true" aria-expanded="false">
							User
						</a>
						<div class="dropdown-menu" aria-labelledby="Preview">
							<a class="dropdown-item" href="{{ route('user.index') }}">List</a>
							<a class="dropdown-item" href="{{ route('admin.recycle') }}" >Recycle</a>
							
						</div>
					</li>
@endsection
@section('content')
<div class="container">
	<div class="content">
		<br>
		<h2 class="display-4">{{ $user->name }}</h2>
		<br>
		<table class="table">
			<tbody>
				<tr>
					<td>Username:</td>
					<td>{{ $user->username }}</td>
				</tr>
				<tr>
					<td>Email:</td>
					<td>{{$user->email }}</td>
				</tr>
				<tr>
					<td>Birthday:</td>
					<td>{{ $user->birthday}}</td>
				</tr>
				<tr>
					<td>Sex:</td>
					<td>{{ $user->sex}}</td>
				</tr>
				<tr>
					<td>Address:</td>
					<td>{{ $user->address}}</td>
				</tr>
				<tr>
					<td>Slogan:</td>
					<td>{{ $user->slogan}}</td>
				</tr>
				
			</tbody>
		</table>
		<!-- Button trigger modal -->
		@if($user->id != Auth::user()->id)
		<a href="javascript:;" class="btn btn-danger " data-toggle="modal" data-target="#myModal">
			Delete
		</a>

		<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title" id="myModalLabel">Xác nhận xóa</h4>
					</div>
					<div class="modal-body">
						Sau khi xóa . user sẽ được chuyển vào Recycle!
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<a href="{{route('user.destroy' , $user->id) }}" onclick="event.preventDefault();
								document.getElementById('delete-form').submit();" type="button" class="btn btn-primary">Delete</a>
								{{ Form::open(array('url' => 'admin/user/' . $user->id, 'class' => 'pull-right', 'style'=>'display:hidden','id'=>'delete-form')) }}
								{{ Form::hidden('_method', 'DELETE') }}
								{{ Form::close() }}
					</div>
				</div>
			</div>
		</div>
		@endif
				<a href="{{ route('user.edit' ,$user->id) }}" class="float-xs-right btn btn-primary"><strong>Update</strong></a>

		</div>
		@endsection