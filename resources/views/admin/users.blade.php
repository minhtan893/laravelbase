@extends('admin.layout')
@section('title','Admin | Users')
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
		<h2 class="display-3 align-center">Users</h2>
		<hr>
		@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Username</th>
					<th>Email</th>
					<th>Full name</th>
					<th>Address</th>
					<th colspan="2">Option</th>
				</tr>
			</thead>
			<tbody>	
				@foreach($users as $user)
				@if($user->level !=0)
				<tr>
					<td><a href="{{route('user.show', $user->id) }}">{{ $user->username }}</a></td>
					<td><p>{{ $user->email }}</p></td>
					<td><p>{{ $user->name }}</p></td>
					<td><p>{{ $user->address }}</p></td>
					<th>
						<a href="javascript:;" class="btn btn-danger btn-sm	 " data-toggle="modal" data-target="#myModal">
							<strong>Delete</strong>
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
										Sau khi xóa . user sẽ được chuyển vào del list!
										{{ Form::open(array('url' => 'admin/user/' . $user->id, 'class' => 'pull-right','id'=>'delete-form')) }}
											<select name='userTranfer'>
												@foreach($usersTranfer as $tranfer)
												<option value={{ $tranfer->id }}>{{ $tranfer->name }}</option>
												@endforeach
											</select>
											{{ Form::hidden('_method', 'DELETE') }}
											{{ Form::close() }}
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
										<a href="{{route('user.destroy' , $user->id) }}" onclick="event.preventDefault();
											document.getElementById('delete-form').submit();" type="button" class="btn btn-primary">Delete</a>
											
										</div>
									</div>
								</div>
							</div>
						</th>
						<th>
							<a href="{{ route('user.edit' ,$user->id) }}" class="float-xs-right btn btn-primary btn-sm"><strong>Update</strong></a>
						</th>
					</tr>
					@endif	
					@endforeach
				</tbody>
			</table>
			
			{{ $users->links('pagination') }}
		</div>
	</div>


	@endsection