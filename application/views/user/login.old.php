<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
        <meta charset="utf-8"/>
        <title><?php echo $title; ?></title>

        <meta name="description" content="User login page"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>

        <!-- bootstrap & fontawesome -->
        <link rel="stylesheet" href="/static/assets/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="/static/jgrowl/jquery.jgrowl.min.css"/>
        <link rel="stylesheet" href="/static/assets/css/font-awesome.min.css"/>

        <!-- text fonts -->
        <link rel="stylesheet" href="/static/assets/css/ace-fonts.css"/>

        <!-- ace styles -->
        <link rel="stylesheet" href="/static/assets/css/ace.min.css"/>

        <!--[if lte IE 9]>
        <link rel="stylesheet" href="/static/assets/css/ace-part2.min.css"/>
        <![endif]-->
        <link rel="stylesheet" href="/static/assets/css/ace-rtl.min.css"/>

        <!--[if lte IE 9]>
        <link rel="stylesheet" href="/static/assets/css/ace-ie.min.css"/>
        <![endif]-->
        <link rel="stylesheet" href="/static/assets/css/ace.onpage-help.css"/>

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

        <!--[if lt IE 9]>
<script src="/static/assets/js/html5shiv.js"></script>
<script src="/static/assets/js/respond.min.js"></script>
<![endif]-->
</head>

<body class="login-layout light-login">
<div class="main-container">
<div class="main-content">
<div class="row">
<div class="col-sm-10 col-sm-offset-1">
<div class="login-container">
<div class="center">
<h1>
<!-- <i class="ace-icon fa fa-leaf green"></i> -->
<span class="white">云报销</span>
<span class="white">管理系统</span>
</h1>
<h4 class="red" id="id-company-text">&copy; 如数科技</h4>
</div>

<div class="space-6"></div>

<div class="position-relative">
<div id="login-box" class="login-box visible widget-box no-border">
<div class="widget-body">
<div class="widget-main">
<h4 class="header blue lighter bigger">
<!--<i class="ace-icon fa fa-coffee green"></i> -->
请登录
</h4>

<div class="space-6"></div>

<form action="<?php echo base_url('login/backyard_login');  ?>" method="post" id="login_form">
<fieldset>
<label class="block clearfix">
<span class="block input-icon input-icon-right">
<input type="text" class="form-control" placeholder="用户名" name="u" id="username" />
<i class="ace-icon fa fa-user"></i>
</span>
</label>

<label class="block clearfix">
<span class="block input-icon input-icon-right">
<input type="password" class="form-control" placeholder="密码" name="p" />
<i class="ace-icon fa fa-lock"></i>
</span>
</label>

<div class="space"></div>

<div class="clearfix">
<!--
<label class="inline">
<input type="checkbox" class="ace"/>
<span class="lbl"> 记住我</span>
</label>
-->

<button id="login_btn" type="button" class="width-35 pull-right btn btn-sm btn-primary">
<i class="ace-icon fa fa-key"></i>
<span class="bigger-110">登录</span>
</button>
</div>

<div class="space-4"></div>
</fieldset>
</form>
<!--
<div class="social-or-login center">
<span class="bigger-110">Or Login Using</span>
</div>

<div class="space-6"></div>

<div class="social-login center">
<a class="btn btn-primary">
<i class="ace-icon fa fa-facebook"></i>
</a>

<a class="btn btn-info">
<i class="ace-icon fa fa-twitter"></i>
</a>

<a class="btn btn-danger">
<i class="ace-icon fa fa-google-plus"></i>
</a>
</div>
-->
</div>
<!-- /.widget-main -->

<!--
<div class="toolbar clearfix">
<div>
<a href="#" data-target="#forgot-box" class="forgot-password-link">
<i class="ace-icon fa fa-arrow-left"></i>
忘记密码
</a>
</div>

<div>
<a href="#" data-target="#signup-box" class="user-signup-link">
注册
<i class="ace-icon fa fa-arrow-right"></i>
</a>
</div>

</div>
-->
</div>
<!-- /.widget-body -->
</div>
<!-- /.login-box -->


<!--
<div class="navbar-fixed-top align-right">
<br/>
&nbsp;
<a id="btn-login-dark" href="#">Dark</a>
    &nbsp;
<span class="blue">/</span>
    &nbsp;
<a id="btn-login-blur" href="#">Blur</a>
    &nbsp;
<span class="blue">/</span>
    &nbsp;
<a id="btn-login-light" href="#">Light</a>
    &nbsp; &nbsp; &nbsp;
</div>
    -->
    </div>
    </div>
    <!-- /.col -->
    </div>
    <!-- /.row -->
    </div>
    <!-- /.main-content -->
    </div>
    <!-- /.main-container -->

    <!-- basic scripts -->

    <!--[if !IE]> -->
    <script type="text/javascript">
window.jQuery || document.write("<script src='/static/assets/js/jquery.min.js'>" + "<" + "/script>");
</script>
<!-- 
Error:
<?php echo $errors; ?>
-->

<!-- <![endif]-->
<!--[if IE]>
<script type="text/javascript">
window.jQuery || document.write("<script src='/static/assets/js/jquery1x.min.js'>" + "<" + "/script>");
</script>
<![endif]-->
<script type="text/javascript">
if ('ontouchstart' in document.documentElement) document.write("<script src='/static/assets/js/jquery.mobile.custom.min.js'>" + "<" + "/script>");
</script>

<script language="javascript" src="/static/jgrowl/jquery.jgrowl.min.js"></script>
<!-- inline scripts related to this page -->
<script type="text/javascript">
var _error = "<?php echo $errors; ?>";
jQuery(function ($) {
    $(document).on('click', '.toolbar a[data-target]', function (e) {
        e.preventDefault();
        var target = $(this).data('target');
        $('.widget-box.visible').removeClass('visible');//hide others
        $(target).addClass('visible');//show target
    });
    $('body').attr('class', 'login-layout');
    $('#id-text2').attr('class', 'white');
    $('#id-company-text').attr('class', 'blue');

    $('#login_btn').on('click', function(){
        $('#login_form').submit();
    });
});


function show_notify(msg, life){
    if(!life || life ==undefined)
        life = 1000;
    $.jGrowl(msg, {'life' : life});
}

//you don't need this, just used for changing background
jQuery(function ($) {
    if(_error) show_notify(_error);

    $('body').attr('class', 'login-layout light-login');
    $('#id-text2').attr('class', 'grey');
    $('#id-company-text').attr('class', 'blue');

    $('#username').focus();
    $('#login_form').keydown(function(e){  
        if(e.keyCode==13){  
            $('#login_form').submit();
        }  
    });

});
</script>
</body>
</html>

