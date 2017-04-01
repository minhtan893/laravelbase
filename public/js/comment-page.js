$('document').ready(function(){

	disableLink();
	onReady();

	$('.comment-form').on('submit',function(){
		var data = new FormData(this);
		$(this).children('textarea').val("");
		$.ajaxSetup({
			headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
		});

		$.ajax({
			method :'post',
			url: url,
			dataType: 'json',
			data: {
				content : data.get('content'),
				parentId : data.get('comment_parent'),
				postId : data.get('postId'),
				userId : data.get('userId'),
				pageId : data.get('pageId')
			},
			success: function(rs){
				if(rs){
					loadMore(rs);
				}
			}
		});
		$('#textarea').val("");
		
		return false;
	});


	$('.comment-section').on('click','.comment-button',function(){
		var html = "<form class='comment-child-form'><textarea class='form-control col-xs-12'  name='content' ></textarea></div>";
		html+="<button class='btn btn-primary' parentId='"+$(this).attr('comment-Id')+"'>Bình luận</button></form>";
		$('.comment-section').children('a').off('click');
		$(this).parent($('.first-comment')).fadeIn('slow', function() {
			$(this).append(html);
		});
	});

	$('.comment-section').on('submit','form',function(){
		$(this).fadeOut('400');
		var content  = $(this).children('textarea').val();
		var parentId = $(this).children('button').attr('parentId');
		childComment(parentId , content);
		return false;
	});

	$('#loadMoreParent').on('click',function(){
		var pageId = $('#pageId').val();
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

	var pageId = $('#pageId').val();
	$.ajaxSetup({
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
	});
	$.ajax({
		url : url,
		type :'post',
		dataType :'json',
		data : {
			pageId : pageId,
			parentId :parentId,
			content : 	content,
			postId : ""
		},
		success :function(rs){
			loadMore(rs);
		}
	});
}

function loadMore(rs){
	if(rs['parentId'] == 0 ){
		var html = "<div class='col-xs-12 first-comment'>";
		html+= "<span><strong>";
		html+=rs['user'];
		html+="</strong></span><small class='text-muted'>";
		html+="&#32;&#32;&#32;&#32; vừa xong";
		html+="</small><p>";
		html+=rs['content'];
		html+="<a href='javascript:;' class='comment-button' comment-Id = '"+rs['id']+"'>Trả lời</a></p><div class='child-comment col-xs-10 col-offset-2' parent-Section='"+rs['id']+"'</div></div>";
		$('.comment-section').fadeIn('1000', function() {
			$(this).append(html);
		});
	}
	else{
		var html = "<div class='col-xs-12'>";
		html+= "<span><strong>";
		html+=rs['user'];
		html+="</strong></span><small class='text-muted'>";
		html+="vừa xong";
		html+="</small><p>";
		html+=rs['content'];
		var tmp = rs['parentId'];
		$('.child-comment').each(function(index, el) {
			if($(this).attr('parent-Section') == tmp){
				$(this).fadeIn('slow',function(){
					$(this).append(html);	
				});
			}
		});
	}

}


function loadMoreParent(pageId , url , start){
	$.ajaxSetup({
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
	});
	$.ajax({

		url : url,
		type : 'get',
		dataType :'json',
		data :{pageId:pageId, start:start},
		success: function(rs){
			var count = rs.length-1;
			if(count>0){
				$('#start').val(rs[count]['id']);
				$.each(rs, function(index, val) {
					var html = "<div class='col-xs-12 first-comment'>";
					html+= "<span><strong>";
					html+=val['user'];
					html+="</strong></span><small class='text-muted'>";
					html+="</small><p>";
					html+=val['content'];
					html+="<a href='javascript:;' class='comment-button' commentId = '"+val['id']+"'>Trả lời</a>";
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
		var pageId = $('#pageId').val();
		var num = 1;
		$(this).children('.child-comment').children(".second").each(function(index, el) {
			num++;
		});
		var count = getMore(parentId , pageId , $(this) ,num );
	});
}

function getMore(parentId , pageId , target , num){
	$.ajax({
		url : url2,
		type:'get',
		dataType:'json',
		data : {parentId : parentId, pageId:pageId},
		success: function(rs){
			if(rs['count']>(num)){
				var html = "<div class='col-xs-12 childLoadMore-div'><a href='javascript:;' class='childLoadMore' comment-Id='"+parentId+"'>Thêm</a></div>";	
				target.append(html);
			}
		}
	});
}


function loadMoreChildComment(parentId , start){
	var pageId = $('#pageId').val();
	$.ajax({
		url : url3,
		type:'get',
		dataType :'json',
		data:{pageId:pageId , parentId:parentId , start:start},
		success : function(rs){
		$.each(rs, function(index, val) {
			var	html= "<div class='col-xs-12 second' commentChild-id = '"+val['id']+"'>";
			html+= "<span><strong>";
			html+=val['user'];
			html+="</strong></span><small class='text-muted'>";

			html+="</small><p>";
			html+=val['content'];
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