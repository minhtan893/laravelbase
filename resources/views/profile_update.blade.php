@extends('main')
@section('title')
{{ $user->name }}
@endsection

@section('content')
<div class=" container content">
	<h2 class="display-2">Cập nhật profile</h2>
	
  <form action="{{ route('front.user.save', $user->id) }}" method="POST">
  {{ csrf_field() }}
    <div class="form-group">
      <label for="name">Họ tên</label>
      <input type="text" class="form-control" id='name' name='name' value="{{ $user->name }}">
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
            <input type="radio" class="form-check-input" name="sex" id="girl" value="girl" checked>
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
  </form>

</div>
@endsection