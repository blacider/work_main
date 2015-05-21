function checkLogin() {
	var inputDOMS = document.getElementsByTagName('input');
    var formDOM = document.getElementsByTagName('form')[0];
    clearError2();
    var ifFalse = false;
  	for (var i = 0; i <= 1; i++)
  		if (isNull(inputDOMS[i].value)) {
  			formDOM.childNodes[(i+1)*2-1].getElementsByTagName('span')[1].style.display = 'block';
  			ifFalse = true;
  		}
      if(ifFalse) return false;
  	if (isEmail(inputDOMS[0].value) || checkMobile(inputDOMS[0].value)) {
        return true;
  		/*----------------success--------------*/
  	} else {
      formDOM.childNodes[1].getElementsByTagName('span')[2].style.display = 'block';
  	}
    return false;
}
function clearError2() {
  var formDOM = document.getElementsByTagName('form')[0];
  formDOM.childNodes[1].getElementsByTagName('span')[2].style.display = 'none';
  for (var i = 0; i <= 1; i++)
        formDOM.childNodes[(i+1)*2-1].getElementsByTagName('span')[1].style.display = 'none';
}
function checkPhone() {
	var inputDOMS = document.getElementsByTagName('input');
    var formDOM = document.getElementsByTagName('form')[1];
    formDOM.childNodes[1].getElementsByTagName('span')[2].style.display = 'none';
    formDOM.childNodes[1].getElementsByTagName('span')[1].style.display = 'none';
    var ifFalse = false;
  	if (isNull(inputDOMS[3].value)) {
  		formDOM.childNodes[1].getElementsByTagName('span')[1].style.display = 'block';
  		ifFalse = true;
  	}
    if(ifFalse) return false;
  	if (checkMobile(inputDOMS[3].value)) {
  		//这里是判断是手机并且成功,此时应发送短信
        $.ajax({
            url: __BASE + "/users/forget",
            dataType: 'json',
            type: 'post',
            data : {'name' : inputDOMS[3].value, 'type' : 1},
            success: function (data){
                if(data.status > 0) {
                    var formDOM = document.getElementsByTagName('form');
                    formDOM[1].style.display = 'none';
                    formDOM[2].getElementsByTagName('input')[0].value = inputDOMS[3].value;
                    formDOM[2].style.display = 'block';
                    time();
                } else {
                    _msg = data.data.msg
                    show_cerror(_msg);
                }
            }
        });



  	} else if (isEmail(inputDOMS[3].value)) {
        $.ajax({
            url: __BASE + "/users/forget",
            dataType: 'json',
            type: 'post',
            data : {'name' : inputDOMS[3].value, 'type' : 0},
            success: function (data){
                if(data.status > 0) {
                    var formDOM = document.getElementsByTagName('form');
                    formDOM[1].style.display = 'none';
                    $('#email').html("<p>请到 "+inputDOMS[3].value+" 查阅来自云报销的邮件，从邮件重设你的密码。</p><div><a href='/'>返回登录页</a></div>");
                    $('#email').show();
                } else {
                    _msg = data.data.msg
                    show_cerror(_msg);
                }
            }
        });
  	} else {
      formDOM.childNodes[1].getElementsByTagName('span')[2].style.display = 'block';
  	}
    return false;
}
function findPassword() {
	var formDOM = document.getElementsByTagName('form');
	formDOM[0].style.display = 'none';
	formDOM[1].style.display = 'block';
}
function checkPhone2() {
	//key = '1234';
	var formDOM = document.getElementsByTagName('form');
	var inputDOMS = document.getElementsByTagName('input');
	formDOM[2].childNodes[3].getElementsByTagName('span')[1].style.display = 'none';
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
function checkPhone3() {
	var formDOM = document.getElementsByTagName('form')[3];
	var inputDOMS = document.getElementsByTagName('input');
	formDOM.childNodes[1].getElementsByTagName('span')[1].style.display = 'none';
	formDOM.childNodes[3].getElementsByTagName('span')[1].style.display = 'none';
    var _pass = $('#pass').val();
    var _pass2 = $('#pass2').val();
	if (!inputDOMS[7].value) {
		formDOM.childNodes[1].getElementsByTagName('span')[1].style.display = 'block';
	} else if (inputDOMS[8].value != inputDOMS[9].value) {
		formDOM.childNodes[3].getElementsByTagName('span')[1].style.display = 'block';
	} 
	else {
		//------------success
        var _phone = $('#phone_hidden').val();
        var _code = $('#code_hidden').val();
        var _pass = inputDOMS[8].value;
        $.ajax({
            url: __BASE + "/users/reset",
            dataType: 'json',
            type: 'post',
            data : {'pass' : _pass, 'code' : _code},
            success: function (data){
                if(data.status > 0) {
                    location.href = __BASE;
                } else {
                    showCodeError(data.msg);
                    //formDOM[2].childNodes[3].getElementsByTagName('span')[1].style.display = 'block';
                }
            }
        });

	}
	return false;
}
function time() {
    var x = document.getElementById('send-again').innerHTML;
    var y = Number(x.split(' ')[1]);
    if (y == 1) {
    	document.getElementById('send-again').innerHTML = x.split(' ')[0];
    	document.getElementById('send-again').click(function() {
            checkPhone();

    		//sendAgin();
    	});
    } else {
    	document.getElementById('send-again').innerHTML = x.split(' ')[0]+' '+String(y-1);
    	setTimeout(time, 1000);
    }
}

function sendAgain() { }

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
function show_cerror(msg, _id) {
    if(!_id) {
        _id = 'cerror'
    }
    $('.error').each(function(){
        $(this).hide();
    });
    $('#' + _id).html(msg);
    $('#' + _id).show();
}
function register(){
	var formDOM = document.getElementsByTagName('form')[3];
	var inputDOMS = document.getElementsByTagName('input');
	formDOM.childNodes[1].getElementsByTagName('span')[1].style.display = 'none';
	formDOM.childNodes[3].getElementsByTagName('span')[1].style.display = 'none';
    var _pass = $('#pass').val();
    var _pass2 = $('#pass2').val();
	if (!inputDOMS[7].value) {
		formDOM.childNodes[1].getElementsByTagName('span')[1].style.display = 'block';
	} else if (inputDOMS[8].value != inputDOMS[9].value) {
		formDOM.childNodes[3].getElementsByTagName('span')[1].style.display = 'block';
	} 
	else {
		//------------success
        formDOM.submit();
	}
	return false;

}


function show_init_error() {
    if(_error != ''){
        var formDOM = document.getElementsByTagName('form')[1];
        $('#error_bad_pass').show();
    }
}
$(document).ready(function(){
    show_init_error();
});
