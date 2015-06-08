
function getPageSize() {
    var xScroll, yScroll;
    if (window.innerHeight && window.scrollMaxY) {
        xScroll = window.innerWidth + window.scrollMaxX;
        yScroll = window.innerHeight + window.scrollMaxY;
    } else {
        if (document.body.scrollHeight > document.body.offsetHeight) { // all but Explorer Mac    
            xScroll = document.body.scrollWidth;
            yScroll = document.body.scrollHeight;
        } else { // Explorer Mac...would also work in Explorer 6 Strict, Mozilla and Safari    
            xScroll = document.body.offsetWidth;
            yScroll = document.body.offsetHeight;
        }
    }
    var windowWidth, windowHeight;
    if (self.innerHeight) { // all except Explorer    
        if (document.documentElement.clientWidth) {
            windowWidth = document.documentElement.clientWidth;
        } else {
            windowWidth = self.innerWidth;
        }
        windowHeight = self.innerHeight;
    } else {
        if (document.documentElement && document.documentElement.clientHeight) { // Explorer 6 Strict Mode    
            windowWidth = document.documentElement.clientWidth;
            windowHeight = document.documentElement.clientHeight;
        } else {
            if (document.body) { // other Explorers    
                windowWidth = document.body.clientWidth;
                windowHeight = document.body.clientHeight;
            }
        }
    }       
    // for small pages with total height less then height of the viewport    
    if (yScroll < windowHeight) {
        pageHeight = windowHeight;
    } else {
        pageHeight = yScroll;
    }    
    // for small pages with total width less then width of the viewport    
    if (xScroll < windowWidth) {
        pageWidth = xScroll;
    } else {
        pageWidth = windowWidth;
    }
    arrayPageSize = new Array(pageWidth, pageHeight, windowWidth, windowHeight);
    return arrayPageSize;
}

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
	$('#android_download').css('display', 'block');
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

function isAndroid() {
	var u = navigator.userAgent, app = navigator.appVersion;
    u = u.toLowerCase();
    return u.match(/android/) == 'android'; //android终端
	//if (isiOS) return true;
	//else return false;
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
        if(isIos()) {
			window.location.href = 'itms-services://?action=download-manifest&url=https://admin.cloudbaoxiao.com/static/reim.104.plist';
        }
        else if(isAndroid()){
			window.location.href = 'https://files-cloudbaoxiao-com.alikunlun.com/release/android/reim.apk';
        } else {
        }
        /*
		if(!isIos()) {
			window.location.href = 'https://files-cloudbaoxiao-com.alikunlun.com/release/android/reim.apk';
		} else {
			window.location.href = 'itms-services://?action=download-manifest&url=https://admin.cloudbaoxiao.com/static/reim.104.plist';
		}
        */
	}
}

$(document).ready(function() {
	/* Act on the event */
    var _s = getPageSize();
    _pw = _s[0];
    _ph = _s[1];
    _ww = _s[2];
    _wh = _s[3];

	$('.contain').css('height', String(_wh) + 'px');
	$('.contain').css('min-height', String(_wh) + 'px');
	/*单页面所做的改变*/

	if (isIos()) {
		$('.android').css('display', 'none');
		$('.ios').css('display', 'block');
        $('.pc').css('display', 'none');
        if(!isWeixin()) {
			window.location.href = 'itms-services://?action=download-manifest&url=https://admin.cloudbaoxiao.com/static/reim.104.plist';
        }
	}
    else if(isAndroid()){
		$('.ios').css('display', 'none');
		$('.android').css('display', 'block');
        $('.pc').css('display', 'none');
        if(!isWeixin()) {
			window.location.href = 'https://files-cloudbaoxiao-com.alikunlun.com/release/android/reim.apk';
        }
    } else {
		$('.ios').css('display', 'none');
		$('.android').css('display', 'none');
        $('.pc').css('display', 'block');
		//$('.ios').css('display', 'block');
		//$('.android').css('display', 'block');
    }
	$('body').scrollTop(0);
});
