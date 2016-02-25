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
    clearErrorLine();
    __IfForget = false;
    var userId = $("#login-text").val();
    __UserId = userId;
    var userLine = $(this).parent();
    if (userId != null && userId != "") {
        if (isEmail(userId)) {
            Utils.api('/register/getvcode/email', {
                method: "post",
                data: {
                    email: userId
                }
            }).done(function (rs) {
                if (rs.code > 0) {
                    $("#email-code").modal('show');
                    $(".phone-text").text(userId);
                    time($("#email-code").find('.timer'), 60);
                    $("#email-code").find("input[name='password']").attr('placeholder', '设置密码');
                } else {
                    userLine.append(getErrorDom(rs['data']['msg']));
                }
            });
        } else if (isPhone(userId)) {
            Utils.api('/register/getvcode/phone', {
                method: "post",
                data: {
                    phone: userId
                }
            }).done(function (rs) {
                if (rs.code > 0) {
                    $("#email-code").modal('show');
                    $(".phone-text").text(userId);
                    time($("#email-code").find('.timer'), 60);
                    $("#email-code").find("input[name='password']").attr('placeholder', '设置密码');
                } else {
                    userLine.append(getErrorDom(rs['data']['msg']));
                }
            });
        } else {
            $(this).parent().append(getErrorDom("格式不正确"));
        }
    } else {
        $(this).parent().append(getErrorDom("请输入邮箱/手机号码"));
    }
  });
  $(".timer").click(function(event) {
        var userId = __UserId;
        if (isEmail(userId)) {
            Utils.api('/register/getvcode/email', {
                method: "post",
                data: {
                    email: userId
                }
            });
        } else if (isPhone(userId)) {
            Utils.api('/register/getvcode/phone', {
                method: "post",
                data: {
                    phone: userId
                }
            });
        }
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
        line.append(getErrorDom("请输入公司名称"));
      }
  });
  $(".modal input[name='name']").blur(function(event) {
      var com = this.value;
      var line = $(this).parent().parent();
      if (com == "") {
        line.append(getErrorDom("请输入姓名"));
      }
  });
  $(".modal input[name='level']").blur(function(event) {
      var com = this.value;
      var line = $(this).parent().parent();
      if (com == "") {
        line.append(getErrorDom("请输入职位"));
      }
  });
  $(".modal input[name='email']").blur(function(event) {
      var com = this.value;
      var line = $(this).parent().parent();
      if (com == "") {
        line.append(getErrorDom("请输入邮箱"));
      } else if (!isEmail(com)) {
        line.append(getErrorDom("邮箱格式错误"));
      }
  });
  $(".modal input[name='phone']").blur(function(event) {
      var com = this.value;
      var line = $(this).parent().parent();
      if (com == "") {
        line.append(getErrorDom("请输入手机"));
      } if (!isPhone(com)) {
        line.append(getErrorDom("手机格式错误"));
        focusLine(line);
        return;
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
var __UserId, __IfForget = false, __vcode, __pass;
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
function focusLine(line) {
    line.find('input').focus();
}
function checkUser() {
    clearErrorLine();
    var user = $("#login input[name='user']").val();
    __UserId = user;
    var userLine = $("#login").find('.user-line');
    if (user == "") {
        userLine.append(getErrorDom("请输入用户名"));
        focusLine(userLine);
    } else if (!isEmail(user) && !isPhone(user)) {
        userLine.append(getErrorDom("请输入正确的邮箱/手机号码"));
        focusLine(userLine);
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
        $("#email-code").find("input[name='password']").attr('placeholder', '设置新密码');
        time($("#email-code").find('.timer'), 60);
    }
    if (isPhone(userId)) {
        $("#phone-code").modal('show');
        $(".phone-text").text(userId);
        time($("#phone-code").find('.timer'), 60);
        $("#phone-code").find("input[name='password']").attr('placeholder', '设置新密码');
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
    var pass = $("#phone-code").find('input[name="password"]').val();
    var codeLine = $("#phone-code").find('.code-line');
    var code = $("#phone-code").find('input[name="code"]').val();
    if (code == undefined || code == "") {
        codeLine.append(getErrorDom("请输入验证码"));
        focusLine(codeLine);
        return;
    } else if (pass == undefined || pass == "") {
        passLine.append(getErrorDom("请输入密码"));
        focusLine(passLine);
        return;
    }
    if (!__IfForget) {
        Utils.api('/register/vcode_verify/phone', {
                method: "post",
                data: {
                    vcode:code,
                    phone: __UserId
                }
            }).done(function (rs) {
                if (rs["data"]["valid"]) {
                    $("#phone-after").modal('show');
                    __vcode = code;
                    __pass = pass;
                } else {
                    codeLine.append(getErrorDom("验证码错误"));
                }
            });
    } else {

    }
}
function checkPass() {
    clearErrorLine();
    var passLine = $("#password").find('.pass-line');
    var pass = $("#password").find('input[name="password"]').val();
    if (pass == "") {
        passLine.append( Dom("请输入密码"));
        focusLine(passLine);
        return;
      } else if (pass.length < 8) {
        passLine.append(getErrorDom("设置密码规范错误"));
        focusLine(passLine);
        return;
      } else {
        var reg = /^([a-zA-Z]+|[0-9]+)$/;
        if (reg.test(pass)) {
            passLine.append(getErrorDom("设置密码规范错误"));
            focusLine(passLine);
            return;
        }
      }
}
function checkEmail() {
    clearErrorLine();
    var passLine = $("#email-code").find('.pass-line');
    var pass = $("#email-code").find('input[name="password"]').val();
    var codeLine = $("#email-code").find('.code-line');
    var code = $("#email-code").find('input[name="code"]').val();
    if (code == undefined || code == "") {
        codeLine.append(getErrorDom("请输入验证码"));
        focusLine(codeLine);
        return;
    } else if (pass == undefined || pass == "") {
        passLine.append(getErrorDom("请输入密码"));
        focusLine(passLine);
        return;
    } else if (pass.length < 8) {
        passLine.append(getErrorDom("设置密码规范错误"));
        focusLine(passLine);
        return;
    } else {
        var reg = /^([a-zA-Z]+|[0-9]+)$/;
        if (reg.test(pass)) {
            passLine.append(getErrorDom("设置密码规范错误"));
            focusLine(passLine);
            return;
        }
    }
    if (!__IfForget) {
        Utils.api('/register/vcode_verify/email', {
                method: "post",
                data: {
                    vcode:code,
                    email: __UserId
                }
            }).done(function (rs) {
                if (rs["data"]["valid"]) {
                    $("#email-after").modal('show');
                    __vcode = code;
                    __pass = pass;
                } else {
                    codeLine.append(getErrorDom("验证码错误"));
                }
            });
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
        focusLine(comLine);
        return;
    } else if (name == "") {
        nameLine.append(getErrorDom("请输入姓名"));
        focusLine(nameLine);
        return;
    } else if (level == "") {
        levelLine.append(getErrorDom("请输入职位"));
        focusLine(levelLine);
        return;
    } else if (email == "") {
        emailLine.append(getErrorDom("请输入手机"));
        focusLine(emailLine);
        return;
    } else if (!isPhone(email)) {
        emailLine.append(getErrorDom("手机格式错误"));
        focusLine(emailLine);
        return;
    }
    Utils.api('/register/company_register/email', {
            method: "post",
            data: {
                email:__vcode,
                password: __pass,
                company_name:com,
                name:name,
                position:level,
                phone:email
        }
    }).done(function (rs) {
        if (rs["code"]) {
            registerSuccess();
        } else {
            comLine.append(getErrorDom(rs["data"]["msg"]));
        }
    });
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
        focusLine(comLine);
        return;
    } else if (name == "") {
        nameLine.append(getErrorDom("请输入姓名"));
        focusLine(nameLine);
        return;
    } else if (level == "") {
        levelLine.append(getErrorDom("请输入职位"));
        focusLine(levelLine);
        return;
    } else if (email == "") {
        emailLine.append(getErrorDom("请输入邮箱"));
        focusLine(emailLine);
        return;
    } else if (!isEmail(email)) {
        emailLine.append(getErrorDom("邮箱格式不正确"));
        focusLine(emailLine);
        return;
    }
    Utils.api('/register/company_register/phone', {
            method: "post",
            data: {
                phone:__vcode,
                password: __pass,
                company_name:com,
                name:name,
                position:level,
                email:email
        }
    }).done(function (rs) {
        if (rs["code"]) {
            registerSuccess();
        } else {
            comLine.append(getErrorDom(re["data"]["msg"]));
        }
    });
}
function checkFirstPass() {
    clearErrorLine();
    var userId = __UserId;
    var passLine = $("#first-login").find('.pass-line');
    var pass = $("#first-login").find('input[name="password"]').val();
    if (pass == undefined || pass == "") {
        passLine.append(getErrorDom("请输入密码"));
        focusLine(passLine);
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
        focusLine(codeLine);
        return;
    }
}
function checkFirstPhoneCode() {
    clearErrorLine();
    var codeLine = $("#first-phone").find('.code-line');
    var code = $("#first-phone").find('input[name="code"]').val();
    if (code == undefined || code == "") {
        codeLine.append(getErrorDom("请输入验证码"));
        focusLine(codeLine);
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
function toLoin() {
    $("#main .login-box .account").focus();
}
function registerSuccess() {
    //do something
    $(".modal").modal("hide");
}