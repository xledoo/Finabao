// JavaScript Document
var lastusername = '', lastpassword = '', lastemail = '', lastinvitecode = '', stmp = new Array(), modifypwd = false, profileTips = '如不需要更改密码，此处请留空';


jQuery(".form-control").each(function(i){
	var check	=	jQuery(".form-control").eq(i).attr("check");
	if(check){
		jQuery(".form-control").eq(i).attr("onblur", check);	
	}
});
function errormessage(id, msg)
{
	msg	=	jQuery("#"+id) ? (!msg ? '' : msg) : '';

	if($('tip_' + id)) {
		if(msg == 'succeed') {
			msg = '';
		}
		
	}
}

function checkusername(id) {
	errormessage(id);
	var username = trim($(id).value);
	if(!username) return;
	if($('tip_' + id).parentNode.className.match(/ p_right/) && (username == '' || username == lastusername)) {	
		return;
	} else {
		lastusername = username;
		alert(lastusername);
	}
	if(username.match(/<|"/ig)) {
		errormessage(id, '用户名包含敏感字符');
		return;
	}
	var unlen = username.replace(/[^\x00-\xff]/g, "**").length;
	if(unlen < 5 || unlen > 15) {
		errormessage(id, unlen < 5 ? '用户名不得小于 5 个字符' : '用户名不得超过 15 个字符');
		return;
	}
	var x = new Ajax();
	$('tip_' + id).parentNode.className = $('tip_' + id).parentNode.className.replace(/ p_right/, '');
	x.get('forum.php?mod=ajax&inajax=yes&infloat=register&handlekey=register&ajaxmenu=1&action=checkusername&username=' + (BROWSER.ie && document.charset == 'utf-8' ? encodeURIComponent(username) : username.replace(/%/g, '%25').replace(/#/g, '%23')), function(s) {
		errormessage(id, s);
	});
}

function showInputTip(id)
{
	alert(id);
}