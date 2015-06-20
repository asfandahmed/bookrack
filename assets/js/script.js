$(document).ready(function(){
	$('.middle-content').scrollPagination({

		nop     : 10, // The number of posts per scroll to be loaded
		offset  : 0, // Initial offset, begins at 0 in this case
		error   : 'No More Posts!', // When the user reaches the end this is the message that is
		                            // displayed. You can change this if you want.
		delay   : 500, // When you scroll down the posts will load after a delayed amount of time.
		               // This is mainly for usability concerns. You can alter this as you see fit
		scroll  : true // The main bit, if set to false posts will not load as the user scrolls. 
		               // but will still load if the user clicks.
		
	});
	$('.comment_bar').hide();
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
	$(document).on("click","#load_message_compose", function(e){
		
		var link=$(this).attr('url');
		$('.modal-dialog').load(link, function( response, status, xhr ){
			if ( status == "error" ) {
			var msg = "Sorry but there was an error: ";
			$( "#contentModal" ).html( msg + xhr.status + " " + xhr.statusText );
			}
		});
	});
	$(document).on("click",".show-messages", function(e){
		
		var link=$(this).attr('data-url');
		$('.modal-dialog').load(link, function( response, status, xhr ){
			 if ( status == "error" ) {
			var msg = "Sorry but there was an error: ";
			$( "#contentModal" ).html( msg + xhr.status + " " + xhr.statusText );
			}else{
				var objDiv = $("#conversation").get(0);
				objDiv.scrollTop = objDiv.scrollHeight;
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
});// document ready

$('.btnBorrow').click(function(event){
	var url=$(this).attr('href');
	var obj={
		"bookId":$(this).attr('bookid'),
		"to":$(this).attr('to'),
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
			humane.log( "Sorry, there was a problem!" );
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
			humane.log('You followed a user');
			console.log(data);
		},
		error:function( xhr, status, errorThrown ){
			humane.log( "Sorry, there was a problem!" );
			console.log( "Error: " + errorThrown );
			console.log( "Status: " + status );
			console.dir( xhr );	
		},
	});
	event.preventDefault();
	event.unbind();
});
$('.SuggfollowBtn').click(function(event){
	var id=$(this).data('user');
	var url=$(this).attr('href');
	$.ajax({
		type : "POST",
		url : url,
		data : { usertobefollowed : id },
		dataType:'json',
		success:function(data){
			$('#row-'+id).fadeOut();
			humane.log('You followed a user');
			console.log(data);
		},
		error:function( xhr, status, errorThrown ){
			humane.log( "Sorry, there was a problem!" );
			console.log( "Error: " + errorThrown );
			console.log( "Status: " + status );
			console.dir( xhr );	
		},
	});
	event.preventDefault();
});
$('.comment-button').click(function(){
	var id = this.id;
	var selector = '#commentbar_'+id;
	$(selector).toggle();
});
$('.commentsloader').on("click", function(e){
		e.preventDefault();
		var link=$(this).attr('href');
		$(this).load(link, function( response, status, xhr ){
			 if ( status == "error" ) {
			var msg = "Sorry but there was an error: ";
			$( "#contentModal" ).html( msg + xhr.status + " " + xhr.statusText );
			}
		});
	});
/*
$('.commentsloader').click(function(event){
	event.preventDefault();
	var url = $(this).attr('href');
	$.ajax({
		type : "GET",
		url : url,
		dataType:'json',
		success:function(data){
			console.log(data);
			view_comments(data);
		},
		error:function( xhr, status, errorThrown ){
			humane.log( "Sorry, there was a problem!" );
			console.log( "Error: " + errorThrown );
			console.log( "Status: " + status );
			console.dir( xhr );	
		},
	});
});*/
function view_comments(data)
{
	
}
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
			humane.log( "Sorry, there was a problem!" );
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
			humane.log( "Sorry, there was a problem!" );
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
				humane.log("Book Added");
			},
			error:function( xhr, status, errorThrown ) {
			humane.log("Add a book name");
			console.log=( "Error: " + errorThrown );
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
				humane.log(data.error);
				$('input[name=status]').val()='';
			},
			error:function( xhr, status, errorThrown ) {
			humane.log( "Sorry, there was a problem!" );
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
			humane.log( "Sorry, there was a problem!" );
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
			humane.log( "Sorry, there was a problem!" );
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
				humane.log(data.error);
			},
			error:function( xhr, status, errorThrown ) {
			humane.log( "Sorry, there was a problem!" );
			console.log( "Error: " + errorThrown );
			console.log( "Status: " + status );
			console.dir( xhr );
			},
		});
		 event.preventDefault();
		 event.unbind();
	});
}
$('.btn-hide').click(function(event){

});
$('.btn-remove').click(function(event){
	var postId = $(this).attr('data-postId');
	var url = $(this).attr('data-url');
	$.ajax({
		type:"POST",
		url:url,
		data:{statusId:postId},
		dataType:'json',
		encode:true,
		success:function(data){
			console.log(data);
			humane.log(data.error);
		},
		error:function( xhr, status, errorThrown ) {
			humane.log( "Sorry, there was a problem!" );
			console.log( "Error: " + errorThrown );
			console.log( "Status: " + status );
			console.dir( xhr );
			},
		complete:function(){
			$('#post_'+postId).fadeOut();
		//location.href = self.href;
		},
	});
	event.preventDefault();
	event.unbind();
});
$('.btn-wishlist').click(function(event){
	var url = $(this).attr('href');
	var btn = $(this);
	var postId = btn.data('post');
	$.ajax({
		type:"POST",
		url:url,
		data:{statusId:postId},
		dataType:'json',
		encode:true,
		success:function(data){
			console.log(data);
		},
		error:function( xhr, status, errorThrown ) {
			humane.log( "Sorry, there was a problem!" );
			console.log( "Error: " + errorThrown );
			console.log( "Status: " + status );
			console.dir( xhr );
			},
		complete:function(){
		//location.href = self.href;
		},
	});
	event.preventDefault();
	event.unbind();
});
/*
function ajax_post_get(type="POST", url, dataType="json", data_obj){
	var result=null;
	$.ajax({
		type : type,
		url : url,
		dataType:'json',
		data:data_obj,
		success:function(data){
			result=data;
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
	return result;
}*/
$('.btn-approve-borrow-request').click(function(event){
	$.ajax({
		type : "GET",
		url : url,
		dataType:'json',
		success:function(data){
			
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
	event.preventDefault();
	event.unbind();
});
$('.btn-ignore-borrow-request').click(function(event){
	$.ajax({
		type : "GET",
		url : url,
		dataType:'json',
		success:function(data){

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
	event.preventDefault();
	event.unbind();
});
/*
function request_borrow()
{

}*/
function displayComment(data)
{
	var commentHTML = createComment(data);
}
function createComment(data)
{
	var html='<div class="col-sm-12 col-md-12 col-lg-12">'+data+'</div>';
	return html;
}
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(savePosition,showError);
    }
}
function savePosition(position){
	var url = 'http://localhost/bookrack/index.php/users/save_lat_lon';
	$.post(url, {
		lat : position.coords.latitude,
		lon : position.coords.longitude
	},
	function(data,status,xhr){
			switch(status){
			case "success":
				location.reload();
			break;
			case "error":
				humane.log("Your request can't be completed. Try later.");
			break;
			case "timeout":
				humane.log("Request time out. Try later.");
			break;
			default:
				humane.log("Unknown error occured please submit your issue at support.");
			break;
			}
		}
	);
}
function showError(error){
	switch(error.code)
    {
        case error.PERMISSION_DENIED: humane.log("user did not share geolocation data");
        break;

        case error.POSITION_UNAVAILABLE: humane.log("could not detect current position");
        break;

        case error.TIMEOUT: humane.log("retrieving position timed out");
        break;

        default: humane.log("unknown error");
        break;
    }
}