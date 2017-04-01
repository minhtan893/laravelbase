@extends('main')
@section('title')
	{{ $user->name }}
@endsection

@section('content')
	<section class="content">
	<h2 class="display-2">Profile</h2>

	<table class="table table-hover">
		<tbody>
			<tr>
				<td>Họ tên</td>
				<td>{{ $user->name }}</td>
			</tr>
			<tr>
				<td>Email</td>
				<td>{{ $user->email }}</td>
			</tr>
			<tr>
				<td>Giới tính</td>
				<td>{{ $user->sex }}</td>
			</tr>
			<tr>
				<td>Ngày sinh</td>
				<td>@if($user->birthday!=null){{ substr($user->birthday , 0 ,10) }}@endif</td>
			</tr>
			<tr>
				<td>Địa chỉ</td>
				<td>{{ $user->address }}</td>
			</tr>
			<tr>
				<td>Slogan</td>
				<td>{{ $user->slogan }}</td>
			</tr>
		</tbody>
	</table>
	<div class='row'>
		<div class="float-xs-right">
			<a href="{{ route('font.user.update',$user->id) }}" class='btn btn-info'>Cập nhật</a>
		</div>
	</div>
	</section>
@endsection