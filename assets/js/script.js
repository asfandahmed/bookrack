$(document).ready(function(){
	$('.comment_bar').hide();
	$('#post_content').scrollPagination({

		nop     : 3, // The number of posts per scroll to be loaded
		offset  : 0, // Initial offset, begins at 0 in this case
		error   : 'No More Posts!', // When the user reaches the end this is the message that is
		                            // displayed. You can change this if you want.
		delay   : 500, // When you scroll down the posts will load after a delayed amount of time.
		               // This is mainly for usability concerns. You can alter this as you see fit
		scroll  : true // The main bit, if set to false posts will not load as the user scrolls. 
		               // but will still load if the user clicks.
		
	});
	$("#profile_pic_box").capslide({
                    caption_color	: '#bfedfa',
                    caption_bgcolor	: '#000',
                    overlay_bgcolor : '#000',
                    border			: '',
                    showcaption	    : false
                });
	$(".ic_container").capslide({
                    caption_color	: '#bfedfa',
                    caption_bgcolor	: '#000',
                    overlay_bgcolor : '#000',
                    border			: '10px solid #e8eced',
                    showcaption	    : true
                });
	// realtime search results
	var url=$('#search-form').attr('action');
			url=url.substring(0,url.lastIndexOf('/')+1);
			url=url.concat("get_suggested_searches");
	$( "input[name=search]" ).autocomplete({
		delay:1000,
		minLength:1,
		source: url,
	});
	// edit profile load div of edit profiles
	/*$('.edit-link').on("click", function(e){
		e.preventDefault();
		var link=$(this).attr('href');
		$('#content-loader').load(link, function( response, status, xhr ){
			 if ( status == "error" ) {
			var msg = "Sorry but there was an error: ";
			$( "#content-loader" ).html( msg + xhr.status + " " + xhr.statusText );
			}
		});
	});*/
	$('#load_messages').on("click", function(e){
		e.preventDefault();
		var link=$(this).attr('href');
		$('#contentModal').load(link, function( response, status, xhr ){
			 if ( status == "error" ) {
			var msg = "Sorry but there was an error: ";
			$( "#contentModal" ).html( msg + xhr.status + " " + xhr.statusText );
			}
		});
	});
	$('#upload_image_loader').on("click", function(e){
		e.preventDefault();
		var link=$(this).attr('href');
		$('#contentModal').load(link, function( response, status, xhr ){
			 if ( status == "error" ) {
			var msg = "Sorry but there was an error: ";
			$( "#contentModal" ).html( msg + xhr.status + " " + xhr.statusText );
			}
		});
	});
	/*$('likes').live("click", function(){
		var element=$(this);
		var per=$(this).parents(".sparkdiv");
		var sid=per.attr("id");
		var htm=$(this).html();
		if(htm=="Like")
		{
		$.ajax({
		type: "POST",
		url: "like.php",
		data: 'sid=' + sid + '&sta=like',
		success: function(reslike){
		if(reslike==1)
		{
		var numlikes=$("#lik"+sid).html();
		numlikes=parseInt(numlikes);
		element.html("Unlike");
		$("#lik"+sid).html(numlikes+1);
		}
		}
		});
		}
		else if(htm=="Unlike")
		{
		$.ajax({
		type: "POST",
		url: "like.php",
		data: 'sid=' + sid + '&sta=unlike',
		success: function(reslike){
		if(reslike==1)
		{
		var numlikes=$("#lik"+sid).html();
		numlikes=parseInt(numlikes);
		element.html("Like");
		$("#lik"+sid).html(numlikes-1);
		}
		}
		});
		}
		return false;

	});*/
});
$('.btnBorrow').click(function(event){
	var url=$('.btnBorrow').attr('href');
	var obj={
		"bookId":$('.btnBorrow').attr('bookid'),
		"to":$('.btnBorrow').attr('to'),
		"bookTitle":$('.btnBorrow').attr('booktitle')
	};
	$.ajax({
		type:"POST",
		url:url,
		data: obj,
		dataType:'json',
		success:function(data){
			console.log(data);
		},
		error:function( xhr, status, errorThrown ){
			alert( "Sorry, there was a problem!" );
			console.log( "Error: " + errorThrown );
			console.log( "Status: " + status );
			console.dir( xhr );	
		},
	});
	event.preventDefault();
	
});
$('#followBtn').click(function(event){
	var id=$('#followBtn').attr('usertobefollowed');
	var url=$('#followBtn').attr('href');
	newurl=url.substring(0,url.lastIndexOf('/')+1);
	newurl=url.concat("unfollow");
	var link='<a class="btn btn-xs btn-default" usertobeunfollowed="'+id+'" id="unfollowBtn" href="'+newurl+'"><span class="glyphicon glyphicon-ban-circle"></span> Unfollow</a>';
	$.ajax({
		type : "POST",
		url : url,
		data : { usertobefollowed : id },
		dataType:'json',
		success:function(data){
			$('#followBtn').replaceWith(link);
			console.log(data);
		},
		error:function( xhr, status, errorThrown ){
			alert( "Sorry, there was a problem!" );
			console.log( "Error: " + errorThrown );
			console.log( "Status: " + status );
			console.dir( xhr );	
		},
	});
	event.preventDefault();
	event.unbind();
});
$('.comment-button').click(function(){
	var id = this.id;
	var selector = '#commentbar_'+id;
	$(selector).toggle();
});
$('.commentsloader').click(function(event){
	event.preventDefault();
	var url = $(this).attr('href');
	$.ajax({
		type : "GET",
		url : url,
		dataType:'json',
		success:function(data){
			console.log(data);
		},
		error:function( xhr, status, errorThrown ){
			alert( "Sorry, there was a problem!" );
			console.log( "Error: " + errorThrown );
			console.log( "Status: " + status );
			console.dir( xhr );	
		},
	});
});
$('.like-button').click(function(event){
	event.preventDefault();
	var url = $(this).attr('href');
	var newurl = url.replace('like','unlike');
	var link = '<a href="'+newurl+'" class="unlike-button">Unlike</a>'
	var selector = $(this);
	$.ajax({
		type : "GET",
		url : url,
		dataType:'json',
		success:function(data){
			$(selector).replaceWith(link);
		},
		error:function( xhr, status, errorThrown ){
			alert( "Sorry, there was a problem!" );
			console.log( "Error: " + errorThrown );
			console.log( "Status: " + status );
			console.dir( xhr );	
		},
		complete:function(){
			location.href = self.href;
		},
	});
});
$('.unlike-button').click(function(event){
	event.preventDefault();
	var url = $(this).attr('href');
	var newurl = url.replace('unlike','like');
	var link = '<a href="'+newurl+'" class="like-button">Like</a>'
	var selector = $(this);
	$.ajax({
		type : "GET",
		url : url,
		dataType:'json',
		success:function(data){
			$(selector).replaceWith(link);
		},
		error:function( xhr, status, errorThrown ){
			alert( "Sorry, there was a problem!" );
			console.log( "Error: " + errorThrown );
			console.log( "Status: " + status );
			console.dir( xhr );	
		},
		complete:function(){
			location.href = self.href;
		},
	});
});
/*
$('#edit-information').click(function(event){
		var link=$(this).attr('href');
		$('#content-loader').load(link, function( link,response, status, xhr ){
			 if ( status == "error" ) {
			var msg = "Sorry but there was an error: ";
			$( "#content-loader" ).html( msg + xhr.status + " " + xhr.statusText );
			}
		});
event.preventDefault();

});
$('#edit-contact').click(function(event){
		var link=$(this).attr('href');
		$('#content-loader').load(link, function( link,response, status, xhr ){
			 if ( status == "error" ) {
			var msg = "Sorry but there was an error: ";
			$( "#content-loader" ).html( msg + xhr.status + " " + xhr.statusText );
			}
		});
event.preventDefault();
});*/
// replace labels with textbox and back to labels
/*function label_to_textbox(){
	    $( ".edit-label" ).replaceWith( function() {
	    	$('.edit-btns').show();
	        return "<input type=\"text\" class=\"form-control edit-text\" value=\"" + $( this ).html() + "\" />";
	    });
}
function textbox_to_label(){
	$( ".edit-text" ).replaceWith( function() {
	        $('.edit-btns').hide();
	        return "<label class=\"col-sm-4 col-md-4 col-lg-4 control-label edit-label\">" + $( this ).val() + "</label>";
	    });
}*/
// add books in wishlist and shelf
function add_books()
{
	$('#book-form').submit(function (event){
		$.ajax({
			type:"POST",
			url:$('#book-form').attr('action'),
			data:$('#book-form').serialize(),
			dataType:'json',
			encode:true,
			success:function(data){
				console.log(data);
				alert('Book added!');
			},
			error:function( xhr, status, errorThrown ) {
			alert( "Sorry, there was a problem!" );
			console.log( "Error: " + errorThrown );
			console.log( "Status: " + status );
			console.dir( xhr );
			},
		});
		event.preventDefault();
		event.unbind();
	});
}
function postStatus()
{
	$('#statusForm').submit(function (event){
		$.ajax({
			type:"POST",
			url:$('#statusForm').attr('action'),
			data:$('#statusForm').serialize(),
			dataType:'json',
			encode:true,
			success:function(data){
				console.log(data);
				alert(data.error);
				$('input[name=status]').val()='';
			},
			error:function( xhr, status, errorThrown ) {
			alert( "Sorry, there was a problem!" );
			console.log( "Error: " + errorThrown );
			console.log( "Status: " + status );
			console.dir( xhr );

			},
		});
		 event.preventDefault();
		 event.unbind();
	});
}
function search_submit(){
	$('#search-form').submit();
}
function like_unlike()
{
	link='<a href="" onClick="return like()">Unlike</a>';
	$('.like-button').live('click', function(e){
		e.preventDefault();
		$.ajax({
			url:$(this).attr('href'),
			method:"POST",
			data:"data",
			dataType:'json',
			encode:true,
			success:function(data)
			{
				$('.like-button').replaceWith(link);
			},
			error:function( xhr, status, errorThrown ) {
			alert( "Sorry, there was a problem!" );
			console.log( "Error: " + errorThrown );
			console.log( "Status: " + status );
			console.dir( xhr );
			},
		});
	});
}
function delete_node(id){
	if(window.confirm("Are you sure you want to delete this?"))
	{
		var selector="#delete_"+id;
		$.ajax({
			url:$(selector).attr('url'),
			method:"POST",
			data:{node_id:id},
			dataType:'json',
			encode:true,
			success:function(data)
			{
				alert(data.msg);
				location.reload();
			},
			error:function( xhr, status, errorThrown ) {
			alert( "Sorry, there was a problem!" );
			console.log( "Error: " + errorThrown );
			console.log( "Status: " + status );
			console.dir( xhr );
			},
		});
	}
	else
		return false;
}
/*$('.commentfield').keypress(function (e) {
  console.log("helloss");
  if (e.which == 13) {
    var p = $(this).parent();
    $(p).submit();
    e.preventDefault();
	e.unbind();
    return false;    //<---- Add this line
	}
});*/
function postComment(id)
{
	var form = '#'+id;
	$(form).submit(function (event){
		$.ajax({
			type:"POST",
			url:$(form).attr('action'),
			data:$(form).serialize(),
			dataType:'json',
			encode:true,
			success:function(data){
				displayComment(data);
			},
			error:function( xhr, status, errorThrown ) {
			alert( "Sorry, there was a problem!" );
			console.log( "Error: " + errorThrown );
			console.log( "Status: " + status );
			console.dir( xhr );
			},
			complete:function(){
			location.href = self.href;
			},
		});
		 event.preventDefault();
		 event.unbind();
	});
}
function displayComment(data)
{
	var commentHTML = createComment(data);
}
function createComment(data)
{
	var html='<div class="col-sm-12 col-md-12 col-lg-12">'+data+'</div>';
	return html;
}