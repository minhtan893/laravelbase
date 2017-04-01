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
		<h2 class="display-4">Update User</h2>
		<hr>
		<br>
		{{ Form::model($user , ['route'=>['user.update',$user->id] , 'method'=>'PATCH' ]) }}
		{{ csrf_field() }}
		<div class="form-group">
			<label for="name">Họ tên</label>
			<input type="text" class="form-control" id='name' name='name' value="{{ $user->name }}">
		</div> 
		<div class="form-group">
			<label for="username">Username</label>
			<input type="text" class="form-control" id='username' name='username' value="{{ $user->username }}">
			@if ($errors->has('username'))
			<span class="help-block">
				<strong>{{ $errors->first('username') }}</strong>
			</span><br/>
			@endif
			<br>
		</div> 
		<div class="form-group">
			<label for="email">Email</label>
			<input type="email" class="form-control" id='name' name='email' value="{{ $user->email }}">
			 @if ($errors->has('email'))
        <span class="help-block">
                         <strong>{{ $errors->first('email') }}</strong>
                                    </span><br/>
@endif
<br>
		</div> 

		<div class="form-group">
			<label for="name">Giới tính</label>
			<fieldset class="form-group">
				<div class="form-check">
					<label class="form-check-label">
						@if($user->sex!=null && $user->sex=='boy')
						<input type="radio" class="form-check-input" name="sex" id="boy" value="boy" checked>
						@else
						<input type="radio" class="form-check-input" name="sex" id="boy" value="boy" >
						@endif
						Boy
					</label>
				</div>
				<div class="form-check ">
					<label class="form-check-label">
						@if($user->sex!=null && $user->sex=='girl')
						<input type="radio" class="form-check-input" name="sex" id="boy" value="girl" checked>
						@else
						<input type="radio" class="form-check-input" name="sex" id="girl" value="girl" >
						@endif
						Girl
					</label>
				</div>
			</fieldset>
		</div>



		<div class="form-group">
			<label for="name">Ngày sinh</label>
			<input type="date" class="form-control" id='date' name='birthday' value="<?php if($user->birthday!=null){ echo $user->birthday; }?>">
		</div> 

		<div class="form-group">
			<label for="address">Địa chỉ</label>
			<input type="text" class="form-control" id='address' name='address' value="{{ $user->address }}">
		</div> 

		<div class="form-group">
			<label for="slogan">Slogan</label>
			<input type="text" class="form-control" id='slogan' name='slogan' value="{{ $user->slogan }}">
		</div>
		<br/>
		<button type="submit" class='btn btn-success'>Cập nhật</button>
		{{ Form::close() }}
	</div>
</div>
@endsection