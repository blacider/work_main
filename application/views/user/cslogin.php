<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
    <title>云报销</title>
    <script>
        console.log('page start', +new Date)
    </script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta name="renderer" content="webkit">

    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-status-bar-style" content="white">
    <meta name="apple-mobile-web-app-capable" content="yes">

    <meta name="description" content="云报销,报销,让报销简单一点儿">
    <meta name="keywords" content="云报销,报销,报销简单点">
    <script src="/static/js/jquery.min.js"></script>
    <script src="/static/js/libs/utils.js"></script>
    <link rel="stylesheet" href="/static/css/mod/login/cslogin.css">
</head>

<body>
    <div class="login">
        <img src="/static/logo.png"  alt="" />
        
            <input placeholder="用户名" type="text" id="uid" name="username" value="" />
            <input placeholder="密码" type="password" id="pwd" name="password" value="" />
            <div id="submit" onclick="login();">登录</div>
        
            <div class="msg"></div>
    </div>
    <!-- <script src="/static/js/libs/jquery/jquery.js"></script> -->
    <!-- <script src="/static/js/boost/utils.js"></script> -->
    <script>
        var $uid = getById('uid');
        var $pwd = getById('pwd');
        setTimeout(function () {
            uid.value = '';
            pwd.value = '';
        }, 1000)
        function getById(id) {
            return document.getElementById(id);
        };

        //写cookies
        function setCookie(name, value, secs) {
            var date = +new Date + secs * 1000;
            document.cookie = name + "=" + value + ";expires=" + date.toUTCString();
        };

        function login() {

            var uid = $uid.value;
            var pwd = $pwd.value;

            if(!uid || !pwd) {
                return false;
            }

            Utils.api('/login/do_login', {
                method: "post",
                data: {
                    u: uid,
                    p: pwd,
                    is_r: "off"
                }
            }).done(function(rs) {
                if (rs['data'] != undefined) {
                    window.location.href = rs['data'];
                } else {
                    var $msg =$('.msg').text(rs['msg']);
                    $msg.show();
                    $msg.fadeOut(2000);
                }
            });

            return true;
        }
    </script>
</body>
</html>