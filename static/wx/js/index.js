function isEmail( str ){  
    var myReg = /^(?:[a-z\d]+[_\-\+\.]?)*[a-z\d]+@(?:([a-z\d]+\-?)*[a-z\d]+\.)+([a-z]{2,})+$/i;
    if(myReg.test(str)) return true; 
    return false; 
}
function check() {
	var errorMsg = "";
	var nameMsg = $('#name').val();
	if (nameMsg == "") {
		errorMsg = "请输入姓名";
	} else {
		dataAjax();
		$('#error').css('visibility', 'hidden');
		return false;
	}
	$('#error').text(errorMsg);
	$('#error').css('visibility', 'visible');
	return false;
}
function dataAjax() {
  $.ajax({
    type: "post",
    url: __BASEURL + "/pub/dojoin",
    data: $('form').serialize(),
    dataType:'jsonp',
    success: function(data) {
      if (data.status)
          ajaxSuccess();
      }
    });
  ajaxSuccess();
}
function ajaxError() {
	$('#error').text("加入失败");
	$('#error').css('visibility', 'visible');
}
function ajaxSuccess() {
	$('form').css('display', 'none');
	$('p')[0].innerHTML = "你已经申请加入";
	$('p')[1].innerHTML = "请下载「云报销」，用当前的微信账号登录，以便及时获得申请结果。";
	$('#download').css('display', 'block');
	if (isIos()) {
		$('.android').css('display', 'none');
		$('.ios').css('display', 'block');
	}
	$('body').scrollTop(0);
}
function isWeixin(){
	var ua = navigator.userAgent.toLowerCase();
	if(ua.match(/MicroMessenger/i)=="micromessenger") {
		return true;
 	} else {
		return false;
	}
}
function isIos() {
	var u = navigator.userAgent, app = navigator.appVersion;
	var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
	if (isiOS) return true;
	else return false;
}
function download() {
	if(isWeixin()) {
		    $('#winxin').css('display', 'block');
		    setTimeout(function(){
		    	$('.block1')[0].onclick = function() {
		    	    $('#winxin').css('display', 'none');
		    	    $('.block1')[0].onclick = function() {
		    	    	return;
		    	    }
		        }
		    },50);
	} else {
		if(!isIos()) {
			window.location.href = 'https://files-cloudbaoxiao-com.alikunlun.com/release/android/reim.apk';
		} else {
			window.location.href = 'itms-services://?action=download-manifest&url=https://admin.cloudbaoxiao.com/static/reim.104.plist';
		}
	}
}
$(document).ready(function() {
	/* Act on the event */
	$('.contain').css('height', String(document.body.scrollHeight));
	/*单页面所做的改变*/
	if (isIos()) {
		$('.android').css('display', 'none');
		$('.ios').css('display', 'block');
	}
	$('body').scrollTop(0);
});
