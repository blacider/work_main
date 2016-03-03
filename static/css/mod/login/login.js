$(document).ready(function(){
    $("#login-m-a").click(function(event) {
        $("#login").modal('show');
    });
    $(document).keypress(function(e) {  
    // 回车键事件  
       if(e.which == 13) {
            var Modals = $(".in");
            if (Modals.length != 0) {
                var Modal = $(Modals[Modals.length/2-1]);
                if (Modal.find('.rightd').click().length == 0) {
                    Modal.find('.right-sm').click();
                }
            }
       }  
   }); 
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
  $("#signin .right-sm").click(function() {
    clearErrorLine();
    __IfForget = false;
    var userId = $("#signin input").val();
    __UserId = userId;
    $("#login").find("input").focus();
    var userLine = $(this).parent().parent();
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
                    userLine.append(getErrorDom("账号已存在"));
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
                    $("#phone-code").modal('show');
                    $(".phone-text").text(userId);
                    time($("#phone-code").find('.timer'), 60);
                    $("#phone-code").find("input[name='password']").attr('placeholder', '设置密码');
                } else {
                    userLine.find('input').focus();
                    userLine.append(getErrorDom("账号已存在"));
                }
            });
        } else {
            userLine.find('input').focus();
            $(this).parent().append(getErrorDom("格式不正确"));
        }
    } else {
        userLine.find('input').focus();
        $(this).parent().append(getErrorDom("请输入邮箱/手机号码"));
    }
  });
  $(".login-button").click(function() {
    clearErrorLine();
    __IfForget = false;
    var userId = $("#login-text").val();
    __UserId = userId;
    $("#login").find("input").focus();
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
                    userLine.append(getErrorDom("账号已存在"));
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
                    $("#phone-code").modal('show');
                    $(".phone-text").text(userId);
                    time($("#phone-code").find('.timer'), 60);
                    $("#phone-code").find("input[name='password']").attr('placeholder', '设置密码');
                } else {
                    userLine.find('.account').focus();
                    userLine.append(getErrorDom("账号已存在"));
                }
            });
        } else {
            userLine.find('.account').focus();
            $(this).parent().append(getErrorDom("格式不正确"));
        }
    } else {
        userLine.find('.account').focus();
        $(this).parent().append(getErrorDom("请输入邮箱/手机号码"));
    }
  });
  $(".timer").click(function(event) {
    if(!__IfForget) {
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
    } else {
        var userId = __UserId;
        if (isEmail(userId)) {
            Utils.api('/register/getvcode/email/reset', {
                method: "post",
                data: {
                    email: userId
                }
            });
        } else if (isPhone(userId)) {
            Utils.api('/register/getvcode/phone/reset', {
                method: "post",
                data: {
                    phone: userId
                }
            });
        }
        time($(this), 60);
    }
        
  });

  $(".modal input[name='user']").blur(function(event) {
      clearErrorLine();
    var user = $("#login input[name='user']").val();
    __UserId = user;
    var userLine = $("#login").find('.user-line');
    if (user != '' && !isEmail(user) && !isPhone(user)) {
        userLine.append(getErrorDom("帐号不存在"));
        focusLine(userLine);
    }
  });
  $(".modal input[name='password']").blur(function(event) {
    clearErrorLine();
      var pass = this.value;
      var passLine = $(this).parent().parent();
      if (pass == '') {return;}
      if (pass.length < 8) {
        passLine.append(getErrorDom("密码长度至少为8位"));
      } else {
        var reg = /^([a-zA-Z]+|[0-9]+)$/;
        if (reg.test(pass)) {
            passLine.append(getErrorDom("密码需同时含有字母和数字"));
        }
      }
  });
  $("#password input[name='password']").unbind();
  $(".modal input[name='email']").blur(function(event) {
    clearErrorLine();
      var com = this.value;
      var line = $(this).parent().parent();
      if (com != '' && !isEmail(com)) {
        line.append(getErrorDom("格式不正确"));
      }
  });
  $(".modal input[name='phone']").blur(function(event) {
    clearErrorLine();
      var com = this.value;
      var line = $(this).parent().parent();
      if (!isPhone(com) && com != '') {
        line.append(getErrorDom("格式不正确"));
        return;
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
        dom.text(counter+"秒后可重发");
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
        userLine.append(getErrorDom("请输入帐号"));
        focusLine(userLine);
    } else if (!isEmail(user) && !isPhone(user)) {
        userLine.append(getErrorDom("帐号不存在"));
        focusLine(userLine);
    } else {
        if (isEmail(user)) {
            Utils.api('/login/check_user/email', {
                method: "post",
                data: {
                    email:user
                }
            }).done(function (rs) {
                if (rs["data"]["exists"]) {
                    if (rs['data']['user']['active'] == 1) {
                        $("#password .user-pic").find('img').attr('src', rs['data']['user']['avatar_url']);
                        $("#password .user-name").text(rs['data']['user']['nickname']);
                        $("#password").modal('show');
                    } else {
                        $("#first-login").modal('show');
                    }
                } else {
                    focusLine(userLine);
                    userLine.append(getErrorDom("账号不存在"));
                }
            });
        } else {
            Utils.api('/login/check_user/phone', {
                method: "post",
                data: {
                    phone:user
                }
            }).done(function (rs) {
                if (rs["data"]["exists"]) {
                    if (rs['data']['user']['active'] == 1) {
                        $("#password .user-pic").find('img').attr('src', rs['data']['user']['avatar_url']);
                        $("#password .user-name").text(rs['data']['user']['nickname']);
                        $("#password").modal('show');
                    } else {
                        $("#first-login").modal('show');
                    }
                } else {
                    focusLine(userLine);
                    userLine.append(getErrorDom("账号不存在"));
                }
            });
        }
    }
}
function forgetPass() {
    __IfForget = true;
    var userId = __UserId;
    if (isEmail(userId)) {
        Utils.api('/register/getvcode/email/reset', {
                method: "post",
                data: {
                    email: userId
                }
            });
        $("#email-code").modal('show');
        $(".phone-text").text(userId);
        $("#email-code").find("input[name='password']").attr('placeholder', '设置新密码');
        time($("#email-code").find('.timer'), 60);
    }
    if (isPhone(userId)) {
        Utils.api('/register/getvcode/phone/reset', {
                method: "post",
                data: {
                    phone: userId
                }
            });
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
    __pass = pass;
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
    } else if (pass.length < 8) {
        passLine.append(getErrorDom("密码长度至少为8位"));
        focusLine(passLine);
        return;
    } else {
        var reg = /^([a-zA-Z]+|[0-9]+)$/;
        if (reg.test(pass)) {
            passLine.append(getErrorDom("密码需同时含有字母和数字"));
            focusLine(passLine);
            return;
        }
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
                    focusLine(codeLine);
                    codeLine.append(getErrorDom("验证码错误"));
                }
            });
    } else {
        Utils.api('/login/reset_password/phone', {
                method: "post",
                data: {
                    vcode:code,
                    password:pass,
                    phone:__UserId
                }
            }).done(function (rs) {
                if (rs["code"] == 0) {
                    registerSuccess("设置密码成功");
                    Utils.api('/login/do_login', {
                method: "post",
                data: {
                    u:__UserId,
                    p: pass,
                    is_r:"off"
                }
            }).done(function (rs) {
                if (rs['data'] != undefined) {
                    window.location.href=rs['data'];
                }
            });
                } else {
                    focusLine(codeLine);
                    codeLine.append(getErrorDom("验证码错误"));
                }
            });
    }
}
function checkPass() {
    clearErrorLine();
    var passLine = $("#password").find('.pass-line');
    var pass = $("#password").find('input[name="password"]').val();
    if (pass == "") {
        passLine.append(getErrorDom("请输入密码"));
        focusLine(passLine);
        return;
    }
    Utils.api('/login/do_login', {
                method: "post",
                data: {
                    u:__UserId,
                    p: pass,
                    is_r:"off"
                }
            }).done(function (rs) {
                if (rs['data'] != undefined) {
                    window.location.href=rs['data'];
                } else {
                    passLine.append(getErrorDom("密码错误"));
                }
            });

}
function checkEmail() {
    clearErrorLine();
    var passLine = $("#email-code").find('.pass-line');
    var pass = $("#email-code").find('input[name="password"]').val();
    __pass = pass;
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
        passLine.append(getErrorDom("密码长度至少为8位"));
        focusLine(passLine);
        return;
    } else {
        var reg = /^([a-zA-Z]+|[0-9]+)$/;
        if (reg.test(pass)) {
            passLine.append(getErrorDom("密码需同时含有字母和数字"));
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
                    focusLine(codeLine);
                    codeLine.append(getErrorDom("验证码错误"));
                }
            });
    } else {
        Utils.api('/login/reset_password/email', {
                method: "post",
                data: {
                    vcode:code,
                    password:pass,
                    email:__UserId
                }
            }).done(function (rs) {
                if (rs["code"] == 0) {
                    registerSuccess("设置密码成功");
                    Utils.api('/login/do_login', {
                method: "post",
                data: {
                    u:__UserId,
                    p: pass,
                    is_r:"off"
                }
            }).done(function (rs) {
                if (rs['data'] != undefined) {
                    window.location.href=rs['data'];
                }
            });
                } else {
                    focusLine(codeLine);
                    codeLine.append(getErrorDom("验证码错误"));
                }
            });
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
        comLine.append(getErrorDom("请输入公司名称"));
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
        emailLine.append(getErrorDom("格式不正确"));
        focusLine(emailLine);
        return;
    }
    Utils.api('/register/company_register', {
            method: "post",
            data: {
                email:__UserId,
                password: __pass,
                company_name:com,
                name:name,
                position:level,
                phone:email,
                vcode:__vcode
        }
    }).done(function (rs) {
        if (rs["code"] >= 0) {
            registerSuccess("注册成功");
            Utils.api('/login/do_login', {
                method: "post",
                data: {
                    u:__UserId,
                    p: __pass,
                    is_r:"off"
                }
            }).done(function (rs) {
                if (rs['data'] != undefined) {
                    window.location.href=rs['data'];
                }
            });
        } else {
            if (rs["data"]["msg"] == "公司名称已存在") {
                focusLine(comLine);
                comLine.append(getErrorDom(rs['data']['msg']));
            } else if (rs["data"]["msg"] == "手机号码已注册") {
                focusLine(emailLine);
                emailLine.append(getErrorDom(rs['data']['msg']));
            } else if (rs["data"]["msg"] == "验证码无效") {
                alert("验证码无效");
            } else {
                focusLine(comLine);
                comLine.append(getErrorDom(rs['data']['msg']));
            }
            
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
        comLine.append(getErrorDom("请输入公司名称"));
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
        emailLine.append(getErrorDom("格式不正确"));
        focusLine(emailLine);
        return;
    }
    Utils.api('/register/company_register', {
            method: "post",
            data: {
                phone:__UserId,
                password: __pass,
                company_name:com,
                name:name,
                position:level,
                email:email,
                vcode:__vcode
        }
    }).done(function (rs) {
        if (rs["code"] >= 0) {
            registerSuccess("注册成功");
            Utils.api('/login/do_login', {
                method: "post",
                data: {
                    u:__UserId,
                    p: __pass,
                    is_r:"off"
                }
            }).done(function (rs) {
                if (rs['data'] != undefined) {
                    window.location.href=rs['data'];
                }
            });
        } else {
            if (rs["data"]["msg"] == "公司名称已存在") {
                focusLine(comLine);
                comLine.append(getErrorDom(rs['data']['msg']));
            } else if (rs["data"]["msg"] == "邮箱已注册") {
                focusLine(emailLine);
                emailLine.append(getErrorDom(rs['data']['msg']));
            } else if (rs["data"]["msg"] == "验证码无效") {
                alert("验证码无效");
            } else {
                focusLine(comLine);
                comLine.append(getErrorDom(rs['data']['msg']));
            }
        }
    });
}
function checkFirstPass() {
    clearErrorLine();
    var userId = __UserId;
    var passLine = $("#first-login").find('.pass-line');
    var pass = $("#first-login").find('input[name="password"]').val();
    __pass = pass;
    if (pass == undefined || pass == "") {
        passLine.append(getErrorDom("请设置密码"));
        focusLine(passLine);
        return;
    } else if (pass.length < 8) {
        passLine.append(getErrorDom("密码长度至少为8位"));
        focusLine(passLine);
        return;
    } else {
        var reg = /^([a-zA-Z]+|[0-9]+)$/;
        if (reg.test(pass)) {
            passLine.append(getErrorDom("密码需同时含有字母和数字"));
            focusLine(passLine);
            return;
        }
    }
    if (isEmail(userId)) {
            Utils.api('/register/getvcode/email/reset', {
                method: "post",
                data: {
                    email: userId
                }
            });
            $(".phone-text").text(userId);
            $("#first-email").modal('show');
            __IfForget = true;
            time($("#first-email").find('.timer'), 60);
        }
        if (isPhone(userId)) {
            Utils.api('/register/getvcode/phone/reset', {
                method: "post",
                data: {
                    phone: userId
                }
            });
            $(".phone-text").text(userId);
            $("#first-phone").modal('show');
            __IfForget = true;
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
    Utils.api('/login/reset_password/email', {
                method: "post",
                data: {
                    vcode:code,
                    password:__pass,
                    email:__UserId
                }
            }).done(function (rs) {
                if (rs["code"] == 0) {
                    registerSuccess("设置密码成功");
                    Utils.api('/login/do_login', {
                method: "post",
                data: {
                    u:__UserId,
                    p: __pass,
                    is_r:"off"
                }
            }).done(function (rs) {
                if (rs['data'] != undefined) {
                    window.location.href=rs['data'];
                }
            });
                } else {
                    focusLine(codeLine);
                    codeLine.append(getErrorDom("验证码错误"));
                }
            });
}
function checkFirstPhoneCode() {
    clearErrorLine();
    var pass = __pass;
    var phone = __UserId;
    var codeLine = $("#first-phone").find('.code-line');
    var code = $("#first-phone").find('input[name="code"]').val();
    if (code == undefined || code == "") {
        codeLine.append(getErrorDom("请输入验证码"));
        focusLine(codeLine);
        return;
    }
    Utils.api('/login/reset_password/phone', {
                method: "post",
                data: {
                    vcode:code,
                    password:pass,
                    phone:__UserId
                }
            }).done(function (rs) {
                if (rs["code"] == 0) {
                    registerSuccess("设置密码成功");
                    Utils.api('/login/do_login', {
                method: "post",
                data: {
                    u:__UserId,
                    p: __pass,
                    is_r:"off"
                }
            }).done(function (rs) {
                if (rs['data'] != undefined) {
                    window.location.href=rs['data'];
                }
            });
                } else {
                    focusLine(codeLine);
                    codeLine.append(getErrorDom("验证码错误"));
                }
            });
}
function getErrorDom(str) {
    //setTimeout(function() {
    //    clearErrorLine();
    //}, 3000);
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
    document.documentElement.scrollTop = document.body.scrollTop =0;
    $("#signin").modal("show");
}
function weixinLogin() {
    var _target = encodeURIComponent('http://admin.cloudbaoxiao.com/login/wxlogin');
    var appid = 'wxa718c52caef08633';
    var scope = 'snsapi_login';
    var httpurl = "https://open.weixin.qq.com/connect/qrconnect?appid=" + appid + "&redirect_uri=" + _target + "&response_type=code&scope=" + scope + "&state=xfjajfldaj#wechat_redirect";
    window.open(httpurl);
}
function show_notify(msg, life){
    if(!life || life ==undefined)
        life = 3000;
    $.jGrowl(msg, {'life' : life});
}
function registerSuccess(msg) {
    if (msg == undefined) {msg = ""}
    show_notify(msg);
    $(".modal").modal("hide");
}