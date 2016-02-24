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
  $(".modal-header").find('button').click(function(event) {
      $(".modal").modal("hide");
  });
  $(".login-button").click(function() {
    __IfForget = false;
    var userId = $("#login-text").val();
    if (userId != null && userId != "") {
        if (isEmail(userId)) {
            $("#email-code").modal('show');
            $(".phone-text").text(userId);
            time($("#email-code").find('.timer'), 60);
            $("#email-code").find("input[name='pass']").attr('placeholder', '设置密码');
        }
        if (isPhone(userId)) {
            $("#phone-code").modal('show');
            $(".phone-text").text(userId);
            time($("#phone-code").find('.timer'), 60);
            $("#phone-code").find("input[name='pass']").attr('placeholder', '设置密码');
        }
    }
  });
  $(".timer").click(function(event) {
      time($(this), 60);
  });

  $(".modal input[name='user']").blur(function(event) {
      checkUser();
  });
  $(".modal input[name='password']").blur(function(event) {
      var pass = this.value;
      var passLine = $(this).parent().parent();
      if (pass == "") {
        passLine.append(getErrorDom("请输入密码"));
      } else if (pass.length < 8) {
        passLine.append(getErrorDom("设置密码规范错误"));
      } else {
        var reg = /^([a-zA-Z]+|[0-9]+)$/;
        if (reg.test(pass)) {
            passLine.append(getErrorDom("设置密码规范错误"));
        }
      }
  });
  $(".modal input[name='com']").blur(function(event) {
      var com = this.value;
      var line = $(this).parent().parent();
      if (com == "") {
        line.append(getErrorDom("请输入公司名称"))；
      }
  });
  $(".modal input[name='name']").blur(function(event) {
      var com = this.value;
      var line = $(this).parent().parent();
      if (com == "") {
        line.append(getErrorDom("请输入姓名"))；
      }
  });
  $(".modal input[name='level']").blur(function(event) {
      var com = this.value;
      var line = $(this).parent().parent();
      if (com == "") {
        line.append(getErrorDom("请输入职位"))；
      }
  });
  $(".modal input[name='email']").blur(function(event) {
      var com = this.value;
      var line = $(this).parent().parent();
      if (com == "") {
        line.append(getErrorDom("请输入邮箱"))；
      }
  });
  $(".modal input[name='phone']").blur(function(event) {
      var com = this.value;
      var line = $(this).parent().parent();
      if (com == "") {
        line.append(getErrorDom("请输入手机"))；
      }
  });
  $(".modal input[name='pass']").blur(function(event) {
      var pass = this.value;
      var passLine = $(this).parent().parent();
      if (pass == "") {
        passLine.append(getErrorDom("请输入密码"));
      } else if (pass.length < 8) {
        passLine.append(getErrorDom("设置密码规范错误"));
      } else {
        var reg = /^([a-zA-Z]+|[0-9]+)$/;
        if (reg.test(pass)) {
            passLine.append(getErrorDom("设置密码规范错误"));
        }
      }
  });
  $(".modal input[name='code']").blur(function(event) {
      var code = this.value;
      var codeLine = $(this).parent().parent();
      if (code == "") {
        codeLine.append(getErrorDom("请输入验证码"));
      }
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
    clearErrorLine();
    var user = $("#login input[name='user']").val();
    __UserId = user;
    var userLine = $("#login").find('.user-line');
    if (user == "") {
        userLine.append(getErrorDom("请输入用户名"));
    } else if (!isEmail(user) && !isPhone(user)) {
        userLine.append(getErrorDom("请输入正确的邮箱/手机号码"));
    } else {
        if (user == "18888888888" || user == "1@1.com") {
            $("#first-login").modal('show');
        } else {
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
        $("#email-code").find("input[name='pass']").attr('placeholder', '设置新密码');
        time($("#email-code").find('.timer'), 60);
    }
    if (isPhone(userId)) {
        $("#phone-code").modal('show');
        $(".phone-text").text(userId);
        time($("#phone-code").find('.timer'), 60);
        $("#phone-code").find("input[name='pass']").attr('placeholder', '设置新密码');
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
    clearErrorLine();
    var passLine = $("#phone-code").find('.pass-line');
    var pass = $("#phone-code").find('input[name="pass"]').val();
    var codeLine = $("#phone-code").find('.code-line');
    var code = $("#phone-code").find('input[name="code"]').val();
    if (code == undefined || code == "") {
        codeLine.append(getErrorDom("请输入验证码"));
        return;
    } else if (pass == undefined || pass == "") {
        passLine.append(getErrorDom("请输入密码"));
        return;
    }
    if (!__IfForget) {
        $("#phone-after").modal('show');
    } else {

    }
}
function checkPass() {
    clearErrorLine();
    var codeLine = $("#password").find('.pass-line');
    var code = $("#password").find('input[name="password"]').val();
    if (code == undefined || code == "") {
        codeLine.append(getErrorDom("请输入密码"));
        return;
    }
}
function checkEmail() {
    clearErrorLine();
    var passLine = $("#email-code").find('.pass-line');
    var pass = $("#email-code").find('input[name="pass"]').val();
    var codeLine = $("#email-code").find('.code-line');
    var code = $("#email-code").find('input[name="code"]').val();
    if (code == undefined || code == "") {
        codeLine.append(getErrorDom("请输入验证码"));
        return;
    } else if (pass == undefined || pass == "") {
        passLine.append(getErrorDom("请输入密码"));
        return;
    }
    if (!__IfForget) {
        $("#email-after").modal('show');
    } else {
        
    }
}
function checkAfterEmail() {
    clearErrorLine();
    var comLine = $("#email-after").find('.com-line');
    var com = $("#email-after").find('input[name="com"]').val();
    var nameLine = $("#email-after").find('.name-line');
    var name = $("#email-after").find('input[name="name"]').val();
    var levelLine = $("#email-after").find('.level-line');
    var level = $("#email-after").find('input[name="level"]').val();
    var emailLine = $("#email-after").find('.phone-line');
    var email = $("#email-after").find('input[name="phone"]').val();
    if (com == "") {
        comLine.append(getErrorDom("请输入公司"));
        return;
    } else if (name == "") {
        nameLine.append(getErrorDom("请输入姓名"));
        return;
    } else if (level == "") {
        levelLine.append(getErrorDom("请输入职位"));
        return;
    } else if (email == "") {
        emailLine.append(getErrorDom("请输入手机"));
        return;
    }
}
function checkAfterPhone() {
    clearErrorLine();
    var comLine = $("#phone-after").find('.com-line');
    var com = $("#phone-after").find('input[name="com"]').val();
    var nameLine = $("#phone-after").find('.name-line');
    var name = $("#phone-after").find('input[name="name"]').val();
    var levelLine = $("#phone-after").find('.level-line');
    var level = $("#phone-after").find('input[name="level"]').val();
    var emailLine = $("#phone-after").find('.email-line');
    var email = $("#phone-after").find('input[name="email"]').val();
    if (com == "") {
        comLine.append(getErrorDom("请输入公司"));
        return;
    } else if (name == "") {
        nameLine.append(getErrorDom("请输入姓名"));
        return;
    } else if (level == "") {
        levelLine.append(getErrorDom("请输入职位"));
        return;
    } else if (email == "") {
        emailLine.append(getErrorDom("请输入邮箱"));
        return;
    }
}
function checkFirstPass() {
    clearErrorLine();
    var userId = __UserId;
    var passLine = $("#first-login").find('.pass-line');
    var pass = $("#first-login").find('input[name="pass"]').val();
    if (pass == undefined || pass == "") {
        passLine.append(getErrorDom("请输入密码"));
        return;
    }
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
    clearErrorLine();
    var codeLine = $("#first-email").find('.code-line');
    var code = $("#first-email").find('input[name="code"]').val();
    if (code == undefined || code == "") {
        codeLine.append(getErrorDom("请输入验证码"));
        return;
    }
}
function checkFirstPhoneCode() {
    clearErrorLine();
    var codeLine = $("#first-phone").find('.code-line');
    var code = $("#first-phone").find('input[name="code"]').val();
    if (code == undefined || code == "") {
        codeLine.append(getErrorDom("请输入验证码"));
        return;
    }
}
function getErrorDom(str) {
    return '<div class="error-login">'+
                '<div class="error-login-line">'+
                    '<span class="error-text">'+
                        str+
                    '</span>'+
                '<div class="error-right">'+
                    '</div>'+
                '</div>'+
            '</div>';
}
function clearErrorLine() {
    $('.error-login').remove();
}