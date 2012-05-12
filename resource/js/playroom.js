$(window).resize(function() {
	resizeContent();
});

$("div[data-role='page']").live( "pageshow", function( event )
{
	resizeContent();
});

function resizeContent()
{
	var contentHeight ;
	var browserWidth = document.documentElement.clientWidth;
	var browserHeight = document.documentElement.clientHeight;
	var headerHeight = parseInt( $("div[data-role='header']").css( "height" ) );
	var footerHeight = parseInt( $("div[data-role='footer']").height());
	if(navigator.userAgent.indexOf('iPhone') != -1 || navigator.userAgent.indexOf('iphone') != -1){
		$("#content").css("height" , browserHeight - headerHeight - footerHeight +60);
	}
	else
		$("#content").css("height" , browserHeight - headerHeight - footerHeight);
	$("#chat").css("height" , contentHeight);	
	$("#gamedisplay").css("height" , browserHeight);
	if(	$("#participant_list").height() < contentHeight)
		$("#participant_list").css("height" , contentHeight);
	$("#chat").css("width" , browserWidth -10);
	$("#button_list").css("width" , browserWidth-10);
	$("#chat_input").css("width" , browserWidth - $("#chat_send").width() - 30);
}

function view(id){
	$("#room_info").css("display" , "none");
	$("#room_config").css("display" , "none");
	$("#chat").css("display" , "none");
	$("#participant_list").css("display" , "none");
	$("#gamedisplay").css("display" , "none");
	$("#"+id).css("display" , "block");
}

function view_config(id){
	$("#room_info").css("display" , "none");
	$("#room_config").css("display" , "none");
	if(id != 'none')
		$("#"+id).css("display" , "block");
}
function view_folding(flag){
	$("#unfold").css("display" , "none");
	$("#fold").css("display" , "none");
	$("#"+flag).css("display" , "block");
	if(flag == 'unfold'){
		$("#room_info").css("display" , "none");
		$("#room_config").css("display" , "none");
	}
}