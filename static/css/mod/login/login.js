$(document).ready(function(){
  $(".icon_close").hover(function(){
    $(".icon_close").attr("src","/static/img/mod/login/closed.png");
    },function(){
    $(".icon_close").attr("src","/static/img/mod/login/close.png");
  });
  $(".icon_left").hover(function(){
    $(".icon_left").attr("src","/static/img/mod/login/leftd.png");
    },function(){
    $(".icon_left").attr("src","/static/img/mod/login/left.png");
  });
  $(".rightd").hover(function(){
    $(".rightd").attr("src","/static/img/mod/login/rightd.png");
    },function(){
    $(".rightd").attr("src","/static/img/mod/login/right.png");
  });
  $(".login-button").click(function() {
    __IfForget = false;
    var userId = $("#login-text").val();
    if (userId != null && userId != "") {
        if (isEmail(userId)) {
            $("#email-code").modal('show');
            $(".phone-text").text(userId);
            time($("#email-code").find('.timer'), 60);
        }
        if (isPhone(userId)) {
            $("#phone-code").modal('show');
            $(".phone-text").text(userId);
            time($("#phone-code").find('.timer'), 60);
        }
    }
  });
  $(".timer").click(function(event) {
      time($(this), 60);
  });
});
var __UserId, __IfForget = false;
function time(dom, counter) {
    if (counter == 0) {
        dom.removeAttr("disabled");            
        dom.text("重发");
        dom.addClass('time-disable');
    } else {
        counter--;
        dom.attr("disabled", true);  
        dom.text(counter+"S后可重发");
        dom.removeClass('time-disable');
        setTimeout(function() {  
            time(dom, counter);
        }, 1000);
    }
}
function isPhone( s ){   
    var regu =/^[1][3,4,5,7,8][0-9]{9}$/; 
    var re = new RegExp(regu); 
    if (re.test(s)) { 
        return true; 
    }else{ 
        return false; 
    } 
}
function isEmail( str ){  
    str = trim(str);
    var myReg = /^[-\._A-Za-z0-9]+@([-_A-Za-z0-9]+\.)+[A-Za-z0-9]{2,3}$/; 
    if(myReg.test(str)) return true; 
    return false; 
}
function checkUser() {
    var user = $("#login input[name='user']").val();
    __UserId = user;
    if (user != '') {
        if (user == "18888888888" || user == "1@1.com") {
            $("#login").modal('hide');
            $("#first-login").modal('show');
        } else {
            $("#login").modal('hide');
            $("#password").modal('show');
        }
    }
}
function forgetPass() {
    __IfForget = true;
    var userId = __UserId;
    if (isEmail(userId)) {
        $("#email-code").modal('show');
        $(".phone-text").text(userId);
        time($("#email-code").find('.timer'), 60);
    }
    if (isPhone(userId)) {
        $("#phone-code").modal('show');
        $(".phone-text").text(userId);
        time($("#phone-code").find('.timer'), 60);
    }
}
function changeVisibility(dom) {
    var inputDom = dom.find('input');
    var imgDom = dom.find("img");
    if (inputDom.attr('type') == 'password') {
        inputDom.attr('type', 'text');
        imgDom.attr('src', '/static/img/mod/login/eyed.png');
    } else {
        inputDom.attr('type', 'password');
        imgDom.attr('src', '/static/img/mod/login/eye.png');
    }
}
function trim(str) {
　return str.replace(/(^\s*)|(\s*$)/g, "");
}
function checkPhone() {
    if (!__IfForget) {
        $("#phone-after").modal('show');
    } else {

    }
}
function checkEmail() {
    if (!__IfForget) {
        $("#email-after").modal('show');
    } else {
        
    }
}
function checkAfterEmail() {

}
function checkAfterPhone() {

}
function checkFirstPass() {
    var userId = __UserId;
    if (isEmail(userId)) {
            $("#first-email").modal('show');
            time($("#first-email").find('.timer'), 60);
        }
        if (isPhone(userId)) {
            $("#first-phone").modal('show');
            time($("#first-phone").find('.timer'), 60);
        }
}
function checkFirstEmailCode() {

}
function checkFirstPhoneCode() {

}