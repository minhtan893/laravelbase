@extends('../main')
@section('content')
<div class="container content">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <h2 class="display-4">Login</h2>
    
                   
                <div class="panel-body" style="margin-top: 50px;">
                 @if($errors->has('login'))
                        <small id="emailHelp" class="form-text text-muted">{{ $errors->first('login') }}</small>
                  @endif   
                    <form method="POST" action="{{ route('admin.submitLogin') }}">
                    {{ csrf_field() }}
                      <div class="form-group">
                            <label for="name">Username hoặc Email</label>
                            <input type="text" class="form-control" id='name' name='name' placeholder="Nhập username hoặc email">
                      </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id='password' name='password' placeholder="Nhập password">
                  </div>
              <button type="submit" class="btn btn-primary">Đăng nhập</button>
          </form>
</div>
</div>
</div>
</div>
</div>
@endsection
