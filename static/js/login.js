//检查第一个表单
function checkLogin() {
	var inputDOMS = document.getElementsByTagName('input');
    var formDOM = document.getElementsByTagName('form')[0];
    clearError2();
    var ifFalse = false;
  	for (var i = 0; i <= 1; i++)
  		if (isNull(inputDOMS[i].value)) {
  			formDOM.getElementsByTagName('span')[i == 0?1:4].style.display = 'block';
  			ifFalse = true;
  		}
      if(ifFalse) return false;
  	if (isEmail(inputDOMS[0].value) || checkMobile(inputDOMS[0].value)) {
  		/*----------------success--------------*/
  		//登录表单校验成功
  		alert(13);
  	} else {
      formDOM.getElementsByTagName('span')[2].style.display = 'block';
  	}
    return false;
}
//清除错误提示
function clearError2() {
  $('.error').css('display', 'none');
}
//检查第二个表单，关于手机的
function checkPhone() {
	var inputDOMS = document.getElementsByTagName('input');
    var formDOM = document.getElementsByTagName('form')[1];
    clearError2();
    var ifFalse = false;
  	if (isNull(inputDOMS[3].value)) {
  		formDOM.getElementsByTagName('span')[1].style.display = 'block';
  		ifFalse = true;
  	}
    if(ifFalse) return false;
  	if (checkMobile(inputDOMS[3].value)) {
  		//这里是判断是手机并且成功,此时应发送短信
  		var formDOM = document.getElementsByTagName('form');
	    formDOM[1].style.display = 'none';
	    formDOM[2].getElementsByTagName('input')[0].value = inputDOMS[3].value;
	    formDOM[2].style.display = 'block';
	    time();
  	} else if (isEmail(inputDOMS[3].value)) {
  		//这里是判断是邮件，此时应发送邮件
  		var formDOM = document.getElementsByTagName('form');
  		formDOM[1].style.display = 'none';
  		document.getElementById('email').getElementsByTagName('p').innerHTML = "请到 "+inputDOMS[3].value+"查阅来自云报销的邮件，从邮件重设你的密码。";
  		document.getElementById('email').style.display = 'block';
  	} else {
      formDOM.getElementsByTagName('span')[2].style.display = 'block';
  	}
    return false;
}
//切换至找回密码表单
function findPassword() {
	var formDOM = document.getElementsByTagName('form');
	formDOM[0].style.display = 'none';
	formDOM[1].style.display = 'block';
}
//检查验证码的表单
function checkPhone2() {
	key = '1234'; //模拟的key
	var formDOM = document.getElementsByTagName('form');
	var inputDOMS = document.getElementsByTagName('input');
	clearError2();
    var _uv = inputDOMS[6].value;
    var _phone = inputDOMS[3].value;
        $.ajax({
            url: __BASE + "/users/forget",
            dataType: 'json',
            type: 'post',
            data : {'name' : _phone, 'type' : 1, 'code' : _uv},
            success: function (data){
                if(data.status > 0) {
                    document.getElementById('step2-title').innerHTML = "修改"+' '+inputDOMS[5].value+' '+"的密码";
                    formDOM[2].style.display = 'none';
                    formDOM[3].style.display = 'block';
                    $('#phone_hidden').val(_phone);
                    $('#code_hidden').val(_uv);
                } else {
                    _msg = data.data.msg
                    show_cerror(_msg, "verror");
                    //formDOM[2].childNodes[3].getElementsbyTagName('span')[1].style.display = 'block';
                }
            }
        });
	return false;
}
//检查修改密码表单中两个密码是否一致，以及是否为空
function checkPhone3() {
	var formDOM = document.getElementsByTagName('form')[3];
	var inputDOMS = document.getElementsByTagName('input');
        clearError2();
    var _pass = $('#pass').val();
    var _pass2 = $('#pass2').val();
	if (!inputDOMS[8].value) {
		formDOM.getElementsByTagName('span')[1].style.display = 'block';
	} else if (inputDOMS[8].value != inputDOMS[9].value) {
		formDOM.getElementsByTagName('span')[3].style.display = 'block';
	} 
	else {
		//------------success
		//修改密码成功
	}
	return false;
}
//重新申请发送验证码倒计时函数
function time() {
    var x = document.getElementById('send-again').innerHTML;
    var y = Number(x.split(' ')[1]);
    if (y == 1) {
    	document.getElementById('send-again').innerHTML = x.split(' ')[0];
    	document.getElementById('send-again').click(function() {
    		sendAgin();
    	});
    } else {
    	document.getElementById('send-again').innerHTML = x.split(' ')[0]+' '+String(y-1);
    	setTimeout(time, 1000);
    }
}
function sendAgain() {
//再次发送短信
}
function backLogin() {
	var formDOM = document.getElementsByTagName('form');
	formDOM[1].style.display = 'none';
	formDOM[0].style.display = 'block';
}
function backStep1() {
	var formDOM = document.getElementsByTagName('form');
	formDOM[2].style.display = 'none';
	formDOM[1].style.display = 'block';
}
function backStep2() {
	var formDOM = document.getElementsByTagName('form');
	formDOM[3].style.display = 'none';
	formDOM[2].style.display = 'block';
}
//显示验证手机返回的错我信息
function showPhoneError(msg) {
	$('#form-phone span')[3].innerHTML = msg;
	$('#form-phone span')[3].style.display = "block";
}
//显示获取验证码返回信息
function showCodeError(msg) {
	$('#form-phone-step1 span')[1].innerHTML = msg;
	$('#form-phone-step1 span')[1].style.display = "block";
}
$(document).ready(function(){
    show_init_error();
      if(document.body.scrollWidth > 900) {
    $('.block1').css('height', String(document.documentElement.clientHeight-220));
    }
});

