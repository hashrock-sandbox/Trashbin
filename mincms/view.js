var canvasfunc = function(){
	//override this
};

function doLogin(){
	var password = $("#password").val();
	$.post(
	    "login",
	    {
			"password": password,
			"action": "login"
		},
	    function(data, status) {
			if(data.result == "success"){
				location.href=document.URL+"edit";
			}else{
				alert("パスワードが間違っています。");
			}
	    },
	    "json"
	);
}

$(function(){
	$(document).ready(function(){
		var dialogOpts = {
			modal: true,
			bgiframe: true,
			autoOpen: false,
			height: 200,
			width: 400,
			draggable: true,
			resizeable: true,
			buttons: {
				"Login": function() {
					$( this ).dialog( "close" );
					doLogin();
				},
				Cancel: function() {
					$( this ).dialog( "close" );
				}
			}
		   };
		$("#loginDialog").dialog(dialogOpts);
	});
	$('#password').keyup(function(e) {
	    if (e.keyCode == 13) {
			$("#loginDialog").dialog( "close" );
			doLogin();
	    }
	});
	ctx = document.getElementById("canv").getContext("2d");  
	int = setInterval(canvasfunc,1);
	canv_h = $("#wrapper").height();
	canv_w = $("#wrapper").width();
	$("#canv").attr({height:canv_h});
	$("#canv").attr({width:canv_w});
	nx =Rnd(canv_w);
	ny =Rnd(canv_h);
});
keyCodeList = new Array(0);
function checkKey(e){
    keyCodeList.push(e.keyCode);
	if(keyCodeList.length > 4){
		keyCodeList.shift();
	}
	if(keyCodeList.length == 4){
		if(
			keyCodeList[0] == 49 &&
			keyCodeList[1] == 50 &&
			keyCodeList[2] == 51 &&
			keyCodeList[3] == 52){
			$("#loginDialog").dialog("open");
			$("#password").focus();
			return false;
		}
	}
}
if ($.browser.mozilla) {
    $(document).keypress (checkKey);
} else {
    $(document).keydown (checkKey);
}

var canv_w;
var canv_h;
var nx;
var ny;
var nz;


var Rnd = function(num){
  return (Math.floor(Math.random()*num));
}
 
