<div class="container">
	<div class="col-xs-12">		<h6>Danh mục</h6>
	</div>
	
	<div class="col-xs-12">
       @foreach ($cates as $cates) {
			<a href="#" >{{ $cate->title }}</a>
       	@endforeach
	</div>
</div>