<html>
<head>
	<title>@yield('title')</title>
	<link rel="stylesheet" href="{{asset('css/app.css') }}">
	<script src="{{asset('js/app.js')}}"></script>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	@yield('script')
</head>
<body>
	<div class="header">
		<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<nav class="navbar navbar-dark bg-primary ">
					<a class="navbar-brand" href="/">Trainee Blog</a>
					<ul class="nav navbar-nav float-xs-right">
					@yield('nav-item')
				<!-- 	<li class="nav-item">
					<a class="nav-link" href="#" >Pages</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">User</a>
					</li> -->
					
				</ul>	
			</nav>
		</div>
		</div>
	</div>		
</div>
<div class="container">
	<div class="col-sm-9 col-xs-12">
		@yield('content')
	</div>
	<div class="col-sm-3 col-xs-12 cate" style="margin-top: 100px;">
		@yield('cate')
	</div>
</div>

<footer id="footer">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<p class="align-center">Design by Losblancos893</p>
				</div>
			</div>
		</div>
	</footer>
</body>
</html>
