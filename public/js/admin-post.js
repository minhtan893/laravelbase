$('document').ready(function(){

	disableLink();
	onReady();

	$('#loadMoreParent').on('click',function(){
		var pageId = $('#postId').val();
		var start = $('#start').val();
		loadMoreParent(pageId , url1 , start);
	})

	$('.comment-section').on('click','.childLoadMore',function(){
		var parentId = $(this).attr('comment-Id');	
		var start = 0;
		$(this).parent('div').parent('.first-comment').children('.child-comment').children('.second').each(function(index, el) {
			start = $(this).attr('commentchild-id');
		});
		loadMoreChildComment(parentId , start);
	})

})

function childComment(parentId , content ){

	var postId = $('#postId').val();
	$.ajaxSetup({
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
	});
	$.ajax({
		url : url,
		type :'post',
		dataType :'json',
		data : {
			pageId : "",
			parentId :parentId,
			content : 	content,
			postId : postId
		},
		success :function(rs){
			loadMore(rs);
		}
	});
}

function loadMoreParent(postId , url , start){
	$.ajaxSetup({
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
	});
	$.ajax({

		url : url,
		type : 'get',
		dataType :'json',
		data :{postId:postId, start:start},
		success: function(rs){
			var count = rs.length-1;
			if(count>0){
				$('#start').val(rs[count]['id']);
				$.each(rs, function(index, val) {
					var html = "<div class='col-xs-12 first-comment'>";
					html+="<span>";
					if(val['deleted_at']==null){
						html+="<strong>";
					}
					else{
						html+="<strong class='text-muted'>";
					}
					html+=val['user'];
					html+="</strong></span><small class='text-muted'>";
					html+="</small><p>";
					html+=val['content'];
					html+=" <a href='admin/comment/delete/"+val['id']+"'  commentId = '"+val['id']+"'>Ẩn</a>";
					html+=" <a href='admin/comment/forceDel/"+val['id']+"'  commentId = '"+val['id']+"'>Xóa</a>";
					html+="<div class='child-comment col-xs-10 col-offset-2' parent-Section='"+val['id']+"'>";
					if(val['child'] !=null){
						html+= "<div class='col-xs-12 second' commentChild-id = '"+val['child']['id']+"'>";
						html+= "<span><strong>";
						html+=val['child']['user'];
						html+="</strong></span><small class='text-muted'>";
						
						html+="</small><p>";
						html+=val['child']['content'];
						html+="</p>";
					}
					html+="</div></div>";
					
					$('.comment-section').fadeIn('slow', function() {
						$(this).append(html);
					});
				});
				onReady();

			}
			else{
				$('#loadMoreParent').remove();
			}
		}

	})
}

function disableLink(){
	$('.main a').each(function(){
		$(this).attr('href','javascript:;');
	})
}

function onReady(){
	$('.first-comment').each(function(index, el) {
		$(this).children('.childLoadMore-div').remove();
		var parentId = $(this).children('.child-comment').attr('parent-Section');
		var postId = $('#postId').val();
		var num = 1;
		$(this).children('.child-comment').children(".second").each(function(index, el) {
			num++;
		});
		var count = getMore(parentId , postId , $(this) ,num );
	});
}

function getMore(parentId , postId , target , num){
	$.ajax({
		url : url2,
		type:'get',
		dataType:'json',
		data : {parentId : parentId, postId:postId},
		success: function(rs){
			if(rs['count']>(num)){
				var html = "<div class='col-xs-12 childLoadMore-div'><a href='javascript:;' class='childLoadMore' comment-Id='"+parentId+"'>Thêm</a></div>";	
				target.append(html);
			}
		}
	});
}


function loadMoreChildComment(parentId , start){
	var postId = $('#postId').val();
	$.ajax({
		url : url3,
		type:'get',
		dataType :'json',
		data:{postId:postId , parentId:parentId , start:start},
		success : function(rs){
		$.each(rs, function(index, val) {
			var	html= "<div class='col-xs-12 second' commentChild-id = '"+val['id']+"'>";
			html+="<span>";
					if(val['deleted_at']==null){
						html+="<strong>";
					}
					else{
						html+="<strong class='text-muted'>";
					}
			html+=val['user'];
			html+="</strong></span><small class='text-muted'>";

			html+="</small><p>";
			html+=val['content'];
			html+=" <a href='admin/comment/delete/"+val['id']+"'  commentId = '"+val['id']+"'>Ẩn</a>";
					html+=" <a href='admin/comment/forceDel/"+val['id']+"'  commentId = '"+val['id']+"'>Xóa</a>";
			html+="</p>";
			html+="</div></div>";

		$('.comment-section').children('.first-comment').each(function(index, el) {
			if($(this).children('.child-comment').attr('parent-section') == parentId){
				$(this).children('.child-comment').append(html);
			}
		});	
		});	
		
		}
	});

	onReady();
}