$(document).ready(function() {
    $("#loading").css('display', 'none');
    (function addJqModalFn() {
        $.fn.modal = function(option) {
            $(".modal").css('display', 'none');
            if ('hide' == option) {
                $(this).css('display', 'none');
            } else if ('show' == option) {
                $(this).css('display', 'block');
            }
            var ifModalExist = false;
            $(".modal").each(function(index, el) {
                if ($(this).css('display') != 'none') {
                    ifModalExist = true;
                }
            });
            if (ifModalExist) {
                $("#login-body").css('display', 'none');
            } else {
                $("#login-body").css('display', 'block');
            }
        }
        $.fn.addError = function(dom) {
            $('body').append(dom);
        }
    })();
    bindEvent();
    function showLoading() {
        $("#loading").css('display', 'block');
    }
    function hideLoading() {
        $("#loading").css('display', 'none');
    }
    (function checkHash() {
        if(location.hash.indexOf('login')!=-1) {
            $('#login-m-a').trigger('click')
        }
    })();
    function bindEvent() {
        timerClickEvent();
        loginButtonClickEvent();
        exitButtonClickEvent();
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

    function isEmail(email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
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
            userLine.addError(getErrorDom("请输入账号"));
            focusLine(userLine);
        } else if (!isEmail(user) && !isPhone(user)) {
            userLine.addError(getErrorDom("格式不正确"));
            focusLine(userLine);
        } else {
            if (isEmail(user)) {
                showLoading();
                Utils.api('/login/check_user/email', {
                    method: "post",
                    data: {
                        email: user
                    }
                }).done(function(rs) {
                    hideLoading();
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
                        userLine.addError(getErrorDom("账号不存在"));
                    }
                });
            } else {
                showLoading();
                Utils.api('/login/check_user/phone', {
                    method: "post",
                    data: {
                        phone: user
                    }
                }).done(function(rs) {
                    hideLoading();
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
                        userLine.addError(getErrorDom("账号不存在"));
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
            codeLine.addError(getErrorDom("请输入验证码"));
            focusLine(codeLine);
            return;
        } else if (pass == undefined || pass == "") {
            passLine.addError(getErrorDom("请输入密码"));
            focusLine(passLine);
            return;
        } else if (pass.length < 8) {
            passLine.addError(getErrorDom("密码长度至少为8位"));
            focusLine(passLine);
            return;
        } else if (ifIncludeUser(pass, _userId)) {
            passLine.addError(getErrorDom("密码不能包含邮箱名"));
            focusLine(passLine);
            return;
        } else {
            var reg = /^([a-zA-Z]+|[0-9]+)$/;
            if (reg.test(pass)) {
                passLine.addError(getErrorDom("密码需同时含有字母和数字"));
                focusLine(passLine);
                return;
            }
        }
        if (!_ifForget) {
            showLoading();
            Utils.api('/register/vcode_verify/phone', {
                method: "post",
                data: {
                    vcode: code,
                    phone: _userId
                }
            }).done(function(rs) {
                hideLoading();
                if (rs["data"]["valid"]) {
                    $("#phone-code").find('input').val("");
                    $("#phone-after").modal('show');
                    _vcode = code;
                    _pass = pass;
                } else {
                    focusLine(codeLine);
                    codeLine.addError(getErrorDom("验证码错误"));
                }
            });
        } else {
            showLoading();
            Utils.api('/login/reset_password/phone', {
                method: "post",
                data: {
                    vcode: code,
                    password: pass,
                    phone: _userId
                }
            }).done(function(rs) {
                hideLoading();
                if (rs["code"] == 0) {
                    $("#phone-code").find('input').val("");
                    registerSuccess("设置密码成功");
                    showLoading();
                    Utils.api('/login/do_login', {
                        method: "post",
                        data: {
                            u: _userId,
                            p: pass,
                            is_r: "off"
                        }
                    }).done(function(rs) {
                        hideLoading();
                        if (rs['data'] != undefined) {
                            window.location.href = rs['data'];
                        }
                    });
                } else {
                    focusLine(codeLine);
                    codeLine.addError(getErrorDom("验证码错误"));
                }
            });
        }
    }

    function checkPass() {
        clearErrorLine();
        var passLine = $("#password").find('.pass-line');
        var pass = $("#password").find('.active-pass').val();
        if (pass == "") {
            passLine.addError(getErrorDom("请输入密码"));
            focusLine(passLine);
            return;
        }
        showLoading();
        Utils.api('/login/do_login', {
            method: "post",
            data: {
                u: _userId,
                p: pass,
                is_r: "off"
            }
        }).done(function(rs) {
            hideLoading();
            if (rs['data'] != undefined) {
                $("#password").find('input').val("");
                window.location.href = rs['data'];
            } else {
                passLine.addError(getErrorDom("密码错误"));
            }
        });

    }
    function ifIncludeUser(pass, user) {
        var userId = user.split("@")[0];
        var reg = new RegExp(userId, 'i');
        return pass.match(reg) != null;
    }
    function checkEmail() {
        clearErrorLine();
        var passLine = $("#email-code").find('.pass-line');
        var pass = $("#email-code").find('.active-pass').val();
        _pass = pass;
        var codeLine = $("#email-code").find('.code-line');
        var code = $("#email-code").find('input[name="code"]').val();
        if (code == undefined || code == "") {
            codeLine.addError(getErrorDom("请输入验证码"));
            focusLine(codeLine);
            return;
        } else if (pass == undefined || pass == "") {
            passLine.addError(getErrorDom("请输入密码"));
            focusLine(passLine);
            return;
        } else if (pass.length < 8) {
            passLine.addError(getErrorDom("密码长度至少为8位"));
            focusLine(passLine);
            return;
        } else if (ifIncludeUser(pass, _userId)) {
            passLine.addError(getErrorDom("密码不能包含邮箱名"));
            focusLine(passLine);
            return;
        } else {
            var reg = /^([a-zA-Z]+|[0-9]+)$/;
            if (reg.test(pass)) {
                passLine.addError(getErrorDom("密码需同时含有字母和数字"));
                focusLine(passLine);
                return;
            }
        }
        if (!_ifForget) {
            showLoading();
            Utils.api('/register/vcode_verify/email', {
                method: "post",
                data: {
                    vcode: code,
                    email: _userId
                }
            }).done(function(rs) {
                hideLoading();
                if (rs["data"]["valid"]) {
                    $("#email-code").find('input').val("");
                    $("#email-after").modal('show');
                    _vcode = code;
                    _pass = pass;
                } else {
                    focusLine(codeLine);
                    codeLine.addError(getErrorDom("验证码错误"));
                }
            });
        } else {
            showLoading();
            Utils.api('/login/reset_password/email', {
                method: "post",
                data: {
                    vcode: code,
                    password: pass,
                    email: _userId
                }
            }).done(function(rs) {
                hideLoading();
                if (rs["code"] == 0) {
                    $("#email-code").find('input').val("");
                    registerSuccess("设置密码成功");
                    showLoading();
                    Utils.api('/login/do_login', {
                        method: "post",
                        data: {
                            u: _userId,
                            p: pass,
                            is_r: "off"
                        }
                    }).done(function(rs) {
                        hideLoading();
                        if (rs['data'] != undefined) {
                            window.location.href = rs['data'];
                        }
                    });
                } else {
                    focusLine(codeLine);
                    codeLine.addError(getErrorDom("验证码错误"));
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
            comLine.addError(getErrorDom("请输入公司名称"));
            focusLine(comLine);
            return;
        } else if (name == "") {
            nameLine.addError(getErrorDom("请输入姓名"));
            focusLine(nameLine);
            return;
        } else if (level == "") {
            levelLine.addError(getErrorDom("请输入职位"));
            focusLine(levelLine);
            return;
        } else if (email == "") {
            emailLine.addError(getErrorDom("请输入手机"));
            focusLine(emailLine);
            return;
        } else if (!isPhone(email)) {
            emailLine.addError(getErrorDom("格式不正确"));
            focusLine(emailLine);
            return;
        }
        showLoading();
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
            hideLoading();
            if (rs["code"] >= 0) {
                registerSuccess("注册成功");
                showLoading();
                Utils.api('/login/do_login', {
                    method: "post",
                    data: {
                        u: _userId,
                        p: _pass,
                        is_r: "off"
                    }
                }).done(function(rs) {
                    hideLoading();
                    if (rs['data'] != undefined) {
                        window.location.href = rs['data'];
                    }
                });
            } else {
                if (rs["data"]["msg"] == "公司名称已存在") {
                    focusLine(comLine);
                    comLine.addError(getErrorDom(rs['data']['msg']));
                } else if (rs["data"]["msg"] == "手机号码已注册") {
                    focusLine(emailLine);
                    emailLine.addError(getErrorDom(rs['data']['msg']));
                } else if (rs["data"]["msg"] == "验证码无效") {
                    alert("验证码无效");
                } else {
                    focusLine(comLine);
                    comLine.addError(getErrorDom(rs['data']['msg']));
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
            comLine.addError(getErrorDom("请输入公司名称"));
            focusLine(comLine);
            return;
        } else if (name == "") {
            nameLine.addError(getErrorDom("请输入姓名"));
            focusLine(nameLine);
            return;
        } else if (level == "") {
            levelLine.addError(getErrorDom("请输入职位"));
            focusLine(levelLine);
            return;
        } else if (email == "") {
            emailLine.addError(getErrorDom("请输入邮箱"));
            focusLine(emailLine);
            return;
        } else if (!isEmail(email)) {
            emailLine.addError(getErrorDom("格式不正确"));
            focusLine(emailLine);
            return;
        }
        showLoading();
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
            hideLoading();
            if (rs["code"] >= 0) {
                registerSuccess("注册成功");
                showLoading();
                Utils.api('/login/do_login', {
                    method: "post",
                    data: {
                        u: _userId,
                        p: _pass,
                        is_r: "off"
                    }
                }).done(function(rs) {
                    hideLoading();
                    if (rs['data'] != undefined) {
                        window.location.href = rs['data'];
                    }
                });
            } else {
                if (rs["data"]["msg"] == "公司名称已存在") {
                    focusLine(comLine);
                    comLine.addError(getErrorDom(rs['data']['msg']));
                } else if (rs["data"]["msg"] == "邮箱已注册") {
                    focusLine(emailLine);
                    emailLine.addError(getErrorDom(rs['data']['msg']));
                } else if (rs["data"]["msg"] == "验证码无效") {
                    alert("验证码无效");
                } else {
                    focusLine(comLine);
                    comLine.addError(getErrorDom(rs['data']['msg']));
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
            passLine.addError(getErrorDom("请设置密码"));
            focusLine(passLine);
            return;
        } else if (pass.length < 8) {
            passLine.addError(getErrorDom("密码长度至少为8位"));
            focusLine(passLine);
            return;
        } else if (ifIncludeUser(pass, _userId)) {
            passLine.addError(getErrorDom("密码不能包含邮箱名"));
            focusLine(passLine);
            return;
        } else {
            var reg = /^([a-zA-Z]+|[0-9]+)$/;
            if (reg.test(pass)) {
                passLine.addError(getErrorDom("密码需同时含有字母和数字"));
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
            codeLine.addError(getErrorDom("请输入验证码"));
            focusLine(codeLine);
            return;
        }
        showLoading();
        Utils.api('/login/reset_password/email', {
            method: "post",
            data: {
                vcode: code,
                password: _pass,
                email: _userId
            }
        }).done(function(rs) {
            hideLoading();
            if (rs["code"] == 0) {
                $("#first-email").find('input').val("");
                registerSuccess("设置密码成功");
                showLoading();
                Utils.api('/login/do_login', {
                    method: "post",
                    data: {
                        u: _userId,
                        p: _pass,
                        is_r: "off"
                    }
                }).done(function(rs) {
                    hideLoading();
                    if (rs['data'] != undefined) {
                        window.location.href = rs['data'];
                    }
                });
            } else {
                focusLine(codeLine);
                codeLine.addError(getErrorDom("验证码错误"));
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
            codeLine.addError(getErrorDom("请输入验证码"));
            focusLine(codeLine);
            return;
        }
        showLoading();
        Utils.api('/login/reset_password/phone', {
            method: "post",
            data: {
                vcode: code,
                password: pass,
                phone: _userId
            }
        }).done(function(rs) {
            hideLoading();
            if (rs["code"] == 0) {
                $("#first-phone").find('input').val("");
                registerSuccess("设置密码成功");
                showLoading();
                Utils.api('/login/do_login', {
                    method: "post",
                    data: {
                        u: _userId,
                        p: _pass,
                        is_r: "off"
                    }
                }).done(function(rs) {
                    hideLoading();
                    if (rs['data'] != undefined) {
                        window.location.href = rs['data'];
                    }
                });
            } else {
                focusLine(codeLine);
                codeLine.addError(getErrorDom("验证码错误"));
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
            '       <span class="error-text">',
                    str,
            '       </span>',
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

    function exitButtonClickEvent() {
        $(".modal-header").find('button').click(function(event) {
            $(".modal").css('display', 'none');
            $("#login-body").css('display', 'block');
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
                    showLoading();
                    Utils.api('/register/getvcode/email', {
                        method: "post",
                        data: {
                            email: userId
                        }
                    }).done(function(rs) {
                        hideLoading();
                        if (rs.code > 0) {
                            $("#signin").find('input').val("");
                            $("#email-code").modal('show');
                            $(".phone-text").text(userId);
                            time($("#email-code").find('.timer'), 60);
                            $("#email-code").find(".active-pass").attr('placeholder', '设置密码');
                        } else {
                            userLine.addError(getErrorDom("账号已存在"));
                        }
                    });
                } else if (isPhone(userId)) {
                    showLoading();
                    Utils.api('/register/getvcode/phone', {
                        method: "post",
                        data: {
                            phone: userId
                        }
                    }).done(function(rs) {
                        hideLoading();
                        if (rs.code > 0) {
                            $("#signin").find('input').val("");
                            $("#phone-code").modal('show');
                            $(".phone-text").text(userId);
                            time($("#phone-code").find('.timer'), 60);
                            $("#phone-code").find(".active-pass").attr('placeholder', '设置密码');
                        } else {
                            userLine.find('input').focus();
                            userLine.addError(getErrorDom("账号已存在"));
                        }
                    });
                } else {
                    userLine.find('input').focus();
                    userLine.addError(getErrorDom("格式不正确"));
                }
            } else {
                userLine.find('input').focus();
                userLine.addError(getErrorDom("请输入邮箱/手机号码"));
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
                    showLoading();
                    Utils.api('/register/getvcode/email', {
                        method: "post",
                        data: {
                            email: userId
                        }
                    }).done(function(rs) {
                        hideLoading();
                        if (rs.code > 0) {
                            $("#email-code").modal('show');
                            $(".phone-text").text(userId);
                            time($("#email-code").find('.timer'), 60);
                            $("#email-code").find(".active-pass").attr('placeholder', '设置密码');
                        } else {
                            userLine.addError(getErrorDom("账号已存在"));
                        }
                    });
                } else if (isPhone(userId)) {
                    showLoading();
                    Utils.api('/register/getvcode/phone', {
                        method: "post",
                        data: {
                            phone: userId
                        }
                    }).done(function(rs) {
                        hideLoading();
                        if (rs.code > 0) {
                            $("#phone-code").modal('show');
                            $(".phone-text").text(userId);
                            time($("#phone-code").find('.timer'), 60);
                            $("#phone-code").find(".active-pass").attr('placeholder', '设置密码');
                        } else {
                            userLine.find('.account').focus();
                            userLine.addError(getErrorDom("账号已存在"));
                        }
                    });
                } else {
                    userLine.find('.account').focus();
                    $(this).parent().addError(getErrorDom("格式不正确"));
                }
            } else {
                userLine.find('.account').focus();
                $(this).parent().addError(getErrorDom("请输入邮箱/手机号码"));
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