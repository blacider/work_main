function isEmail( str ){  
    var myReg = /^(?:[a-z\d]+[_\-\+\.]?)*[a-z\d]+@(?:([a-z\d]+\-?)*[a-z\d]+\.)+([a-z]{2,})+$/i;
    if(myReg.test(str)) return true; 
    return false; 
}

function getPlatform() {
	var ua =detect.parse(navigator.userAgent);
	return ua['os']['family']
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
	if (getPlatform() == 'iOS') {
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

$(document).ready(function() {
	/* Act on the event */
	$('.contain').css('height', String(document.body.scrollHeight));
	/*单页面所做的改变*/
	var platform = getPlatform();
	if (platform == 'iOS') {
        //window.location.href = 'itms-services://?action=download-manifest&url=https://admin.cloudbaoxiao.com/static/reim.111.plist';
        $('.android, .pc').hide();
		$('.ios').css('display', 'block');
        
	} else if(platform == 'Android') {
        $('.ios, .pc').hide();
		$('.android').css('display', 'block');
    } else {
        $('.android, .ios').hide();
		$('.pc').css('display', 'block');
    }
	$('body').scrollTop(0);

	$('.btn-download').on('click', function (e) {
		var href = $(e.currentTarget).data('href');
		var in_weixin = isWeixin();
		if(in_weixin) {
		    $('#winxin').css('display', 'block');
		    if(getPlatform() == 'iOS') {
		    	$('#winxin .safari').show();
		    	$('#winxin .explore').hide();
		    } else {
		    	$('#winxin .safari').hide();
		    	$('#winxin .explore').show();
		    }
		    setTimeout(function(){
		    	$('.block1')[0].onclick = function() {
		    	    $('#winxin').css('display', 'none');
		    	    $('.block1')[0].onclick = function() {
		    	    	return;
		    	    }
		        }
		    },50);
		} else {
			if(getPlatform() == 'iOS') {
	            setTimeout(function (argument) {
					window.location.href = href;
				}, 100)
				_hmt.push('_trackEvent', 'install_page_download', _CONST_FR_, 'ios');
				_hmt.push(['_setCustomVar', 2, 'install_page_ios_download', _CONST_FR_, 2]);
			} else {
				
				_hmt.push('_trackEvent', 'install_page_download', _CONST_FR_, 'android_other');
				_hmt.push(['_setCustomVar', 2, 'install_page_android_other_download', _CONST_FR_, 2]);
				setTimeout(function (argument) {
					window.location.href = href;
				}, 100)
			}
		}
	})

});
