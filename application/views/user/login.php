<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>云报销,让报销简单点</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="云报销,报销,让报销简单一点儿">
        <meta name="keywords" content="云报销,报销,报销简单点">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <link rel="shortcut icon" href="favicon.ico" />
        <link rel="icon" href="/static/favicon.ico">
        <link rel="stylesheet" type="text/css" href="/static/css/main.login.css" />
<script type="text/javascript" src="/static/ace/js/jquery.min.js"></script>
<!--[if IE 6]>
<script src="js/DD_belatedPNG_0.0.8a-min.js"></script>
<script>
DD_belatedPNG.fix('*');
</script>
<![endif]-->
                                    </head>
                                    <body>
                                        <div class="mainForm">
                                            <div class="mainForm_logo"><img src="/static/images/logo2.png" /></div>
                                            <div class="mainForm_body">
                                                <form action="<?php echo base_url('login/dologin');  ?>" method="post" id="login_form">
                                                    <input name="u" type="text" class="br2 inp inp_1" placeholder="邮箱/手机" autofocus="autofocus" />
                                                    <input name="p" type="password" class="br2 inp inp_2" placeholder="密码" />
                                                    <input id="submitbtn" type="button" class="br2 btn" value="登录" />
                                                    <div class="clear mainForm_ft">
                                                        <span class="fl tips"><?php echo $errors; ?></span>
                                                        <!-- <span class="fr link"><a href="">忘记密码？</a></span> -->
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
<script language="javascript">

$(document).ready(function(){
    $('#login_form').keydown(function(e){  
        if(e.keyCode==13){  
            $('#login_form').submit();
        }  
    });
    $('#submitbtn').click(function(){
        $('#login_form').submit();
    });
});
</script>
                                    </body>
                                </html>
