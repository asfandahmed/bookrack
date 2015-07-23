var notify_timer=0;
$(document).ready(function(){
	notify();
	notify_timer = setTimeout(notify,60000); //60 secs
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
	$(document).on("click","#back_messages", function(e){
		
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
$(document).on("click",".btnBorrow",function(event){
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
	$(this).unbind();
});
$(document).on("click","#followBtn",function(event){
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
	$(this).unbind();
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
$(document).on('click','.comment-button', function(){
	var id = $(this).attr('data-post');
	var selector = '#commentbar_'+id;
	$(selector).toggle("slow");
});
$(document).on("click",".commentsloader",function(e){
	e.preventDefault();
		var link=$(this).attr('href');
		$(this).parent().load(link, function( response, status, xhr ){
			if ( status == "error" ) {
			var msg = "Sorry but there was an error: ";
			$( "#contentModal" ).html( msg + xhr.status + " " + xhr.statusText );
			}
		});
});
function notify()
{
	$.ajax({
		type : "GET",
		url : 'http://localhost/bookrack/index.php/check_notification',
		dataType:'json',
		success:function(data){
			if(data.success){
				$('#top-navbar .navitems li:nth-child(2) a').append('<span class="glyphicon glyphicon-exclamation-sign"> </span>');
				$('#top-navbar .navitems li:nth-child(2) a').attr('title','You have new notifications.');
				clearTimeout(notify_timer);
			}
		},
		error:function( xhr, status, errorThrown ){
			console.log( "Error: " + errorThrown );
			console.log( "Status: " + status );
			console.dir( xhr );
		}
	});
}
function view_comments(data)
{
	
}
$(document).on("click",".like-button",function(event){
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
		}
	});
	event.preventDefault();
	$(this).unbind();
});
$(document).on("click",".unlike-button",function(event){
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
		}
	});
	event.preventDefault();
	$(this).unbind();
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
function uploadProfileImage()
{
	var options = {
		target:   '#output',   // target element(s) to be updated with server response
        beforeSubmit:  beforeSubmit,  // pre-submit callback
        resetForm: true,        // reset the form after successful submit 
        dataType: 'json',
        success: successProfileImage,
	};
	$(document).on("submit",'#profile_image_form', function (event){
		$(this).ajaxSubmit(options);
		return false;
		});
}
function successProfileImage(data) {
	var html = '<img class="no-resposive-image" src="'+data.path+'" alt="Profile picture" title="">';
	$('#loading-img').css("display","none");
	$('input#submit-btn').css("display","block");
	if(data.error=="success"){
		$('#profilePicture').attr("src",data.path);
		$('#pictureStatus').html(data.msg);
	}
	$('#output').html(html);
}
//function to check file size before uploading.
function beforeSubmit(){
    //check whether browser fully supports all File API
   if (window.File && window.FileReader && window.FileList && window.Blob)
    {
       
        if( !$('#imageInput').val()) //check empty input filed
        {
            $("#output").html("Are you kidding me?");
            return false
        }
       
        var fsize = $('#imageInput')[0].files[0].size; //get file size
        var ftype = $('#imageInput')[0].files[0].type; // get file type
       

        //allow only valid image file types
        switch(ftype)
        {
            case 'image/png': case 'image/gif': case 'image/jpeg': case 'image/pjpeg':
                break;
            default:
                $("#output").html("<b>"+ftype+"</b> Unsupported file type!");
                return false
        }
       
        //Allowed file size is less than 1 MB (2048576)
        if(fsize>2048576)
        {
            $("#output").html("<b>"+fsize +"</b> Too big Image file! <br />Please reduce the size of your photo using an image editor.");
            return false
        }
               
        $('#submit-btn').hide(); //hide submit button
        $('#loading-img').show(); //hide submit button
        $("#output").html("");  
    }
    else
    {
        //Output error to older browsers that do not support HTML5 File API
        $("#output").html("Please upgrade your browser, because your current browser lacks some new features we need!");
        return false;
    }
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
				after_status_post(data);
			},
			error:function( xhr, status, errorThrown ) {
			humane.log( "Sorry, there was a problem!" );
			console.log( "Error: " + errorThrown );
			console.log( "Status: " + status );
			console.dir( xhr );

			}
		});
		 event.preventDefault();
		 $(this).unbind();
	});
}
function after_status_post(data){
	if(data.success==true){
		$('#statusForm').find("input[name=status]").val('');
		//post = create_post(data); 
		//$('#post-content').prepend(post);
	}
	humane.log(data.error);
}
function search_submit(){
	$('#search-form').submit();
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
function postComment(id)
{
	var form = $(id)[0];
	$(form).bind('submit',function(event){
		if(!event) event = window.event;
		$.ajax({
			type:"POST",
			url:$(form).attr('action'),
			data:$(form).serialize(),
			dataType:'json',
			encode:true,
			cache: false,
			success:function(data){
				if(data.success){
					var html = createComment(data);
					$(form).parents().eq(1).before(html).fadeIn(2000);
					$(form).find("input[name=comment]").val('');
				}else
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
		$(this).unbind();
	});
}
$(document).on("submit","#message-form",function(event){

	$.ajax({
		type:"POST",
		url:$('#message-form').attr('action'),
		data:$('#message-form').serialize(),
		dataType:'json',
		encode:true,
		cache: false,
		success:function(data){
			if(data.success){
				after_message_sent('#message-form');	
			}else
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
	$(this).unbind();
});
	
function after_message_sent(id)
{
	var url=$(id).attr('action');
	var email=$(id+' input[name="email"]').val();
		url=url.substring(0,url.lastIndexOf('/')+1);
		url=url.concat("show/");
		url = url+encodeURIComponent(email); 
		console.log(url);
	$('.modal-dialog').load(url, function( response, status, xhr ){
			 if ( status == "error" ) {
			var msg = "Sorry but there was an error: ";
			$( "#contentModal" ).html( msg + xhr.status + " " + xhr.statusText );
			}else{
				var objDiv = $("#conversation").get(0);
				objDiv.scrollTop = objDiv.scrollHeight;
			}
		});
}
$('.btn-hide').click(function(event){

});
$(document).on("click",".btn-remove",function(event){
	var postId = $(this).attr('data-postId');
	var url = $(this).attr('data-url');
	$.ajax({
		type:"POST",
		url:url,
		data:{statusId:postId},
		dataType:'json',
		encode:true,
		success:function(data){
			if(data.success)
				$('#post_'+postId).fadeOut();	
			humane.log(data.error);
		},
		error:function( xhr, status, errorThrown ) {
			humane.log( "Sorry, there was a problem!" );
			console.log( "Error: " + errorThrown );
			console.log( "Status: " + status );
			console.dir( xhr );
		}
	});
	event.preventDefault();
	$(this).unbind();
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
function ajax_post_get(
	type="POST", url, 
	dataType="json", 
	data_obj, 
	func_success(data){}, 
	func_error( xhr, status, errorThrown ) { humane.log( "Sorry, there was a problem!" ); console.log( "Error: " + errorThrown ); console.log( "Status: " + status ); console.dir( xhr );}, 
	func_complete(){}
	{
		var result=null;
		$.ajax({
			type : type,
			url : url,
			dataType:'json',
			data:data_obj,
			success:function(data){
				func_success(data);
			},
			error:function( xhr, status, errorThrown ){
				func_error( xhr, status, errorThrown );
			},
			complete:function(){
				func_complete();
			},
		});
	return result;
}*/
$(document).on("click",".btn-approve-borrow-request",function(event){
	var element = $(this);
	$.ajax({
		type : "GET",
		url : $(this).attr('href'),
		dataType:'json',
		success:function(data){
			$(element).fadeOut();
		},
		error:function( xhr, status, errorThrown ){
			alert( "Sorry, there was a problem!" );
			console.log( "Error: " + errorThrown );
			console.log( "Status: " + status );
			console.dir( xhr );	
		}
	});
	event.preventDefault();
	$(this).unbind();
});
$(document).on("click",".btn-ignore-borrow-request",function(event){
	var element  = $(this);
	$.ajax({
		type : "GET",
		url : $(this).attr('href'),
		dataType:'json',
		success:function(data){
			$(element).fadeOut();
		},
		error:function( xhr, status, errorThrown ){
			alert( "Sorry, there was a problem!" );
			console.log( "Error: " + errorThrown );
			console.log( "Status: " + status );
			console.dir( xhr );	
		}
	});
	event.preventDefault();
	$(this).unbind();
});
$(document).on("click",".btn-cancel-borrow-request",function(event){
	var element = $(this);
	$.ajax({
		type : "GET",
		url : $(this).attr('href'),
		dataType:'json',
		success:function(data){
			$(element).fadeOut();
		},
		error:function( xhr, status, errorThrown ){
			alert( "Sorry, there was a problem!" );
			console.log( "Error: " + errorThrown );
			console.log( "Status: " + status );
			console.dir( xhr );	
		}
	});
	event.preventDefault();
	$(this).unbind();
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
	//$(data.comment).each(function(){
		var html='<div class="row"><div class="col-xs-3 col-sm-2 col-md-2 col-lg-2"><img style="width:45px;height:35px;" title="'+data.comment.fullname+'" alt="'+data.comment.fullname+'" src="'+data.comment.image+'"></div>';
		html+='<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">'+data.comment.commentText+'</div></div>';	
		return html;
	//});
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