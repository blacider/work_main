$(document).ready(function() {
    bindEvent();

    function bindEvent() {
        timerClickEvent();
        loginButtonClickEvent();
        enterPressEvent();
        exitButtonClickEvent();
        iconWhenHoverEvent();
        nextStepButtonClickEvent();
        signinButtonClickEvent();
    }
    var _userId, _ifForget = false,
        _vcode, _pass, _codeCounter;

    function time(dom, counter) {
        if (counter == 60) {
            _codeCounter = 60;
        } else if (_codeCounter != counter) {
            return;
        }
        if (counter == 0) {
            dom.removeAttr("disabled");
            dom.text("重发验证码");
            dom.addClass('time-disable');
        } else {
            _codeCounter--;
            counter--;
            dom.attr("disabled", true);
            dom.text(counter + "秒后可重发");
            dom.removeClass('time-disable');
            setTimeout(function() {
                time(dom, counter);
            }, 1000);
        }
    }

    function isPhone(s) {
        var regu = /^[1][3,4,5,7,8][0-9]{9}$/;
        var re = new RegExp(regu);
        if (re.test(s)) {
            return true;
        } else {
            return false;
        }
    }

    function isEmail(str) {
        str = trim(str);
        var myReg = /^[-\._A-Za-z0-9]+@([-_A-Za-z0-9]+\.)+[A-Za-z0-9]{2,3}$/;
        if (myReg.test(str)) return true;
        return false;
    }

    function focusLine(line) {
        line.find('input').focus();
    }
    function checkUser() {
        clearErrorLine();
        var user = $("#login input[name='user']").val();
        _userId = user;
        var userLine = $("#login").find('.user-line');
        if (user == "") {
            userLine.append(getErrorDom("请输入账号"));
            focusLine(userLine);
        } else if (!isEmail(user) && !isPhone(user)) {
            userLine.append(getErrorDom("格式不正确"));
            focusLine(userLine);
        } else {
            if (isEmail(user)) {
                Utils.api('/login/check_user/email', {
                    method: "post",
                    data: {
                        email: user
                    }
                }).done(function(rs) {
                    if (rs["data"]["exists"]) {
                        $("#login").find('input').val("");
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
                        phone: user
                    }
                }).done(function(rs) {
                    if (rs["data"]["exists"]) {
                        $("#login").find('input').val("");
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
        _ifForget = true;
        var userId = _userId;
        if (isEmail(userId)) {
            Utils.api('/register/getvcode/email/reset', {
                method: "post",
                data: {
                    email: userId
                }
            });
            $("#email-code").modal('show');
            $(".phone-text").text(userId);
            $("#email-code").find(".active-pass").attr('placeholder', '设置新密码');
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
            $("#phone-code").find(".active-pass").attr('placeholder', '设置新密码');
        }
    }

    function changeVisibility(dom) {
        var activeInputDom = dom.find('.active-pass');
        var hiddenInputDom = dom.find('.hidden-pass');
        var imgDom = dom.find("img");
        hiddenInputDom.val(activeInputDom.val());
        if (activeInputDom.attr('type') == 'password') {
            imgDom.attr('src', '/static/img/mod/login/eyed.png');
        } else {
            imgDom.attr('src', '/static/img/mod/login/eye.png');
        }
        activeInputDom.removeClass('active-pass').addClass('hidden-pass');
        hiddenInputDom.addClass('active-pass').removeClass('hidden-pass');
    }

    function trim(str) {　
        return str.replace(/(^\s*)|(\s*$)/g, "");
    }

    function checkPhone() {
        clearErrorLine();
        var passLine = $("#phone-code").find('.pass-line');
        var pass = $("#phone-code").find('.active-pass').val();
        _pass = pass;
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
        if (!_ifForget) {
            Utils.api('/register/vcode_verify/phone', {
                method: "post",
                data: {
                    vcode: code,
                    phone: _userId
                }
            }).done(function(rs) {
                if (rs["data"]["valid"]) {
                    $("#phone-code").find('input').val("");
                    $("#phone-after").modal('show');
                    _vcode = code;
                    _pass = pass;
                } else {
                    focusLine(codeLine);
                    codeLine.append(getErrorDom("验证码错误"));
                }
            });
        } else {
            Utils.api('/login/reset_password/phone', {
                method: "post",
                data: {
                    vcode: code,
                    password: pass,
                    phone: _userId
                }
            }).done(function(rs) {
                if (rs["code"] == 0) {
                    $("#phone-code").find('input').val("");
                    registerSuccess("设置密码成功");
                    Utils.api('/login/do_login', {
                        method: "post",
                        data: {
                            u: _userId,
                            p: pass,
                            is_r: "off"
                        }
                    }).done(function(rs) {
                        if (rs['data'] != undefined) {
                            window.location.href = rs['data'];
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
        var pass = $("#password").find('.active-pass').val();
        if (pass == "") {
            passLine.append(getErrorDom("请输入密码"));
            focusLine(passLine);
            return;
        }
        Utils.api('/login/do_login', {
            method: "post",
            data: {
                u: _userId,
                p: pass,
                is_r: "off"
            }
        }).done(function(rs) {
            if (rs['data'] != undefined) {
                $("#password").find('input').val("");
                window.location.href = rs['data'];
            } else {
                passLine.append(getErrorDom("密码错误"));
            }
        });

    }

    function checkEmail() {
        clearErrorLine();
        var passLine = $("#email-code").find('.pass-line');
        var pass = $("#email-code").find('.active-pass').val();
        _pass = pass;
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
        if (!_ifForget) {
            Utils.api('/register/vcode_verify/email', {
                method: "post",
                data: {
                    vcode: code,
                    email: _userId
                }
            }).done(function(rs) {
                if (rs["data"]["valid"]) {
                    $("#email-code").find('input').val("");
                    $("#email-after").modal('show');
                    _vcode = code;
                    _pass = pass;
                } else {
                    focusLine(codeLine);
                    codeLine.append(getErrorDom("验证码错误"));
                }
            });
        } else {
            Utils.api('/login/reset_password/email', {
                method: "post",
                data: {
                    vcode: code,
                    password: pass,
                    email: _userId
                }
            }).done(function(rs) {
                if (rs["code"] == 0) {
                    $("#email-code").find('input').val("");
                    registerSuccess("设置密码成功");
                    Utils.api('/login/do_login', {
                        method: "post",
                        data: {
                            u: _userId,
                            p: pass,
                            is_r: "off"
                        }
                    }).done(function(rs) {
                        if (rs['data'] != undefined) {
                            window.location.href = rs['data'];
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
                email: _userId,
                password: _pass,
                company_name: com,
                name: name,
                position: level,
                phone: email,
                vcode: _vcode
            }
        }).done(function(rs) {
            if (rs["code"] >= 0) {
                registerSuccess("注册成功");
                Utils.api('/login/do_login', {
                    method: "post",
                    data: {
                        u: _userId,
                        p: _pass,
                        is_r: "off"
                    }
                }).done(function(rs) {
                    if (rs['data'] != undefined) {
                        window.location.href = rs['data'];
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
                phone: _userId,
                password: _pass,
                company_name: com,
                name: name,
                position: level,
                email: email,
                vcode: _vcode
            }
        }).done(function(rs) {
            if (rs["code"] >= 0) {
                registerSuccess("注册成功");
                Utils.api('/login/do_login', {
                    method: "post",
                    data: {
                        u: _userId,
                        p: _pass,
                        is_r: "off"
                    }
                }).done(function(rs) {
                    if (rs['data'] != undefined) {
                        window.location.href = rs['data'];
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
        var userId = _userId;
        var passLine = $("#first-login").find('.pass-line');
        var pass = $("#first-login").find('.active-pass').val();
        _pass = pass;
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
        $("#first-login").find('input').val("");
        if (isEmail(userId)) {
            Utils.api('/register/getvcode/email/reset', {
                method: "post",
                data: {
                    email: userId
                }
            });
            $(".phone-text").text(userId);
            $("#first-email").modal('show');
            _ifForget = true;
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
            _ifForget = true;
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
                vcode: code,
                password: _pass,
                email: _userId
            }
        }).done(function(rs) {
            if (rs["code"] == 0) {
                $("#first-email").find('input').val("");
                registerSuccess("设置密码成功");
                Utils.api('/login/do_login', {
                    method: "post",
                    data: {
                        u: _userId,
                        p: _pass,
                        is_r: "off"
                    }
                }).done(function(rs) {
                    if (rs['data'] != undefined) {
                        window.location.href = rs['data'];
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
        var pass = _pass;
        var phone = _userId;
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
                vcode: code,
                password: pass,
                phone: _userId
            }
        }).done(function(rs) {
            if (rs["code"] == 0) {
                $("#first-phone").find('input').val("");
                registerSuccess("设置密码成功");
                Utils.api('/login/do_login', {
                    method: "post",
                    data: {
                        u: _userId,
                        p: _pass,
                        is_r: "off"
                    }
                }).done(function(rs) {
                    if (rs['data'] != undefined) {
                        window.location.href = rs['data'];
                    }
                });
            } else {
                focusLine(codeLine);
                codeLine.append(getErrorDom("验证码错误"));
            }
        });
    }
    var _clearErrorFuns = 0;

    function getErrorDom(str) {
        _clearErrorFuns++;
        setTimeout(function() {
            if (_clearErrorFuns == 1) {
                clearErrorLine();
                _clearErrorFuns--;
            } else if (_clearErrorFuns > 1) {
                _clearErrorFuns--;
            }
        }, 3000);
        return [
            '<div class="error-login">',
            '   <div class="error-login-line">',
            '       <span class="error-text">',
                    str,
            '       </span>',
            '       <div class="error-right">',
            '       </div>',
            '   </div>',
            '</div>'
        ].join('');
    }

    function clearErrorLine() {
        $('.error-login').remove();
    }

    function toLoin() {
        document.documentElement.scrollTop = document.body.scrollTop = 0;
        $("#signin").modal("show");
    }

    function weixinLogin() {
        var _target = encodeURIComponent('http://admin.cloudbaoxiao.com/login/wxlogin');
        var appid = 'wxa718c52caef08633';
        var scope = 'snsapi_login';
        var httpurl = "https://open.weixin.qq.com/connect/qrconnect?appid=" + appid + "&redirect_uri=" + _target + "&response_type=code&scope=" + scope + "&state=xfjajfldaj#wechat_redirect";
        window.open(httpurl);
    }

    function show_notify(msg, life) {
        if (!life || life == undefined)
            life = 3000;
        $.jGrowl(msg, {
            'life': life
        });
    }

    function registerSuccess(msg) {
        if (msg == undefined) {
            msg = ""
        }
        show_notify(msg);
        $(".modal").modal("hide");
    }

    function loginButtonClickEvent() {
        $("#login-m-a").click(function(event) {
            $("#login").modal('show');
        });
    }

    function enterPressEvent() {
        $(document).keypress(function(e) {
            // 回车键事件  
            if (e.which == 13) {
                var Modals = $(".in");
                if (Modals.length != 0) {
                    var Modal = $(Modals[Modals.length / 2 - 1]);
                    if (Modal.find('.rightd').click().length == 0) {
                        Modal.find('.right-sm').click();
                    }
                } else {
                    $(".login-button").click();
                }
                return false;
            }
        });
    }

    function iconWhenHoverEvent() {
        $(".icon_close").hover(function() {
            $(".icon_close").attr("src", "/static/img/mod/login/closed.png");
        }, function() {
            $(".icon_close").attr("src", "/static/img/mod/login/close.png");
        });
        $(".icon_left").hover(function() {
            $(".icon_left").attr("src", "/static/img/mod/login/leftd.png");
        }, function() {
            $(".icon_left").attr("src", "/static/img/mod/login/left.png");
        });
        $(".rightd").hover(function() {
            $(".rightd").attr("src", "/static/img/mod/login/rightd.png");
        }, function() {
            $(".rightd").attr("src", "/static/img/mod/login/right.png");
        });
    }

    function exitButtonClickEvent() {
        $(".modal-header").find('button').click(function(event) {
            $(".modal").modal("hide");
        });
    }

    function nextStepButtonClickEvent() {
        $("#login .rightd").click(function(event) {
            checkUser();
        });
        $("#login .weixin").click(function(event) {
            weixinLogin();
        });
        $("#first-login .rightd").click(function(event) {
            checkFirstPass();
        });
        $(".eye").click(function(event) {
            changeVisibility($(this).parent());
        });
        $("#password .rightd").click(function(event) {
            checkPass();
        });
        $("#password .forget-pass a").click(function(event) {
            forgetPass();
        });
        $("#first-phone .rightd").click(function(event) {
            checkFirstPhoneCode();
        });
        $("#first-email .rightd").click(function(event) {
            checkFirstEmailCode();
        });
        $("#phone-code .rightd").click(function(event) {
            checkPhone();
        });
        $("#email-code .rightd").click(function(event) {
            checkEmail();
        });
        $("#phone-after .rightd").click(function(event) {
            checkAfterPhone();
        });
        $("#email-after .rightd").click(function(event) {
            checkAfterEmail();
        });
        $(".register").click(function(event) {
            toLoin();
        });

        $("#signin .rightd").click(function() {
            clearErrorLine();
            _ifForget = false;
            var userId = $("#signin input").val();
            _userId = userId;
            $("#login").find("input").focus();
            var userLine = $("#signin .user-line");
            if (userId != null && userId != "") {
                if (isEmail(userId)) {
                    Utils.api('/register/getvcode/email', {
                        method: "post",
                        data: {
                            email: userId
                        }
                    }).done(function(rs) {
                        if (rs.code > 0) {
                            $("#signin").find('input').val("");
                            $("#email-code").modal('show');
                            $(".phone-text").text(userId);
                            time($("#email-code").find('.timer'), 60);
                            $("#email-code").find(".active-pass").attr('placeholder', '设置密码');
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
                    }).done(function(rs) {
                        if (rs.code > 0) {
                            $("#signin").find('input').val("");
                            $("#phone-code").modal('show');
                            $(".phone-text").text(userId);
                            time($("#phone-code").find('.timer'), 60);
                            $("#phone-code").find(".active-pass").attr('placeholder', '设置密码');
                        } else {
                            userLine.find('input').focus();
                            userLine.append(getErrorDom("账号已存在"));
                        }
                    });
                } else {
                    userLine.find('input').focus();
                    userLine.append(getErrorDom("格式不正确"));
                }
            } else {
                userLine.find('input').focus();
                userLine.append(getErrorDom("请输入邮箱/手机号码"));
            }
        });
    }

    function signinButtonClickEvent() {
        $(".login-button").click(function() {
            clearErrorLine();
            _ifForget = false;
            var userId = $("#login-text").val();
            _userId = userId;
            $("#login").find("input").focus();
            var userLine = $(this).parent();
            if (userId != null && userId != "") {
                if (isEmail(userId)) {
                    Utils.api('/register/getvcode/email', {
                        method: "post",
                        data: {
                            email: userId
                        }
                    }).done(function(rs) {
                        if (rs.code > 0) {
                            $("#email-code").modal('show');
                            $(".phone-text").text(userId);
                            time($("#email-code").find('.timer'), 60);
                            $("#email-code").find(".active-pass").attr('placeholder', '设置密码');
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
                    }).done(function(rs) {
                        if (rs.code > 0) {
                            $("#phone-code").modal('show');
                            $(".phone-text").text(userId);
                            time($("#phone-code").find('.timer'), 60);
                            $("#phone-code").find(".active-pass").attr('placeholder', '设置密码');
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
    }

    function timerClickEvent() {
        $(".timer").click(function(event) {
            if (!_ifForget) {
                var userId = _userId;
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
                var userId = _userId;
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
    }
});