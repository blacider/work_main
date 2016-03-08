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
function isAndroid(){
	var ua = navigator.userAgent.toLowerCase();
	if(ua.match(/android/i)=="android") {
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
};
function download(e) {
	
}
$(document).ready(function() {
	/* Act on the event */
	$('.contain').css('height', String(document.body.scrollHeight));
	/*单页面所做的改变*/
	if (isIos()) {
        //window.location.href = 'itms-services://?action=download-manifest&url=https://admin.cloudbaoxiao.com/static/reim.111.plist';
        $('.android').hide();
		$('.pc').hide();
		$('#download').css('display', 'block');
        $('.ios').show();
		$('.ios').css('display', 'block');
        $('.ios').show();
	} else if(isAndroid()) {
        //window.location.href = 'https://files-cloudbaoxiao-com.alikunlun.com/release/android/1.1.1/reim.apk';
		$('#download ').css('display', 'block');
        $('.android').show();
		$('.android').css('display', 'block');
		$('.ios').css('display', 'none');
		$('.pc').css('display', 'none');
    } else {
        $('.download').hide();
		$('.android').hide();
		$('.ios').hide();
		$('.pc').show();
    }
	$('body').scrollTop(0);

	$('#download').on('click', function (e) {
		var href = $(e.currentTarget).data('href');
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
			if(isIos()) {
	            setTimeout(function (argument) {
					window.location.href = href;
				}, 100)
				_hmt.push('_trackEvent', 'install_page_download', getParameterByName('fr'), 'ios');
				_hmt.push(['_setCustomVar', 2, 'install_page_ios_download', getParameterByName('fr'), 2]);
			} else {
				
				_hmt.push('_trackEvent', 'install_page_download', getParameterByName('fr'), 'android_other');
				_hmt.push(['_setCustomVar', 2, 'install_page_android_other_download', getParameterByName('fr'), 2]);
				setTimeout(function (argument) {
					window.location.href = href;
				}, 100)
			}
		}
	})

});
