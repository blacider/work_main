<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
        <meta charset="utf-8"/>
        <title>重置密码</title>

        <meta name="description" content="如数云管理后台"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>

        <!-- bootstrap & fontawesome -->
        <link rel="stylesheet" href="/static/assets/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="/static/assets/css/font-awesome.min.css"/>

        <!-- text fonts -->
        <link rel="stylesheet" href="/static/assets/css/ace-fonts.css"/>

        <!-- ace styles -->
        <link rel="stylesheet" href="/static/assets/css/ace.min.css" id="main-ace-style"/>

        <!--[if lte IE 9]>
        <link rel="stylesheet" href="/static/assets/css/ace-part2.min.css"/>
        <![endif]-->
        <link rel="stylesheet" href="/static/assets/css/ace-rtl.min.css"/>

        <!--[if lte IE 9]>
        <link rel="stylesheet" href="/static/assets/css/ace-ie.min.css"/>
        <![endif]-->
 <link rel="stylesheet" href="/static/jgrowl/jquery.jgrowl.css" />
        <link rel="stylesheet" href="/static/assets/css/ace.onpage-help.css"/>
<script language="javascript" src="/static/js/jquery.min.js"></script>
<script language="javascript" src="/static/jgrowl/jquery.jgrowl.min.js"></script>

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

        <!--[if lt IE 9]>
<script src="/static/assets/js/html5shiv.js"></script>
<script src="/static/assets/js/respond.min.js"></script>
<![endif]-->

<!--[if !IE]> -->
<script type="text/javascript">
window.jQuery || document.write("<script src='/static/assets/js/jquery.min.js'>" + "<" + "/script>");
</script>

<!-- <![endif]-->

<!--[if IE]>
<script type="text/javascript">
window.jQuery || document.write("<script src='/static/assets/js/jquery1x.min.js'>" + "<" + "/script>");
</script>
<![endif]-->
<script type="text/javascript">
if ('ontouchstart' in document.documentElement) document.write("<script src='/static/assets/js/jquery.mobile.custom.min.js'>" + "<" + "/script>");
</script>



</head>

<body  class="login-layout light-login">
    <div class="main-container">
        <div class="main-content">
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1">
                    <div class="login-container">
                        <div class="center">
                            <h1>
                            </h1>
                        </div>

                        <div class="space-6"></div>

                        <div class="position-relative">

                            <div id="login-box" class="login-box visible widget-box no-border">
                                <div class="widget-body">
                                    <div class="widget-main">
                                        <h4 class="header blue lighter bigger">
                                            <i class="ace-icon fa fa-key green"></i>
                                            重置密码
                                        </h4>

                                        <div class="space-6"></div>

                                        <form action="/resetpwd/doupdate" method="post" id="reform">
                                            <fieldset>
                                                <label class="block clearfix">
                                                    <span class="block input-icon input-icon-right">
                                                        <input type="password" name="pass" class="form-control" placeholder="新密码" />
                                                    </span>
                                                </label>

                                                <label class="block clearfix">
                                                    <span class="block input-icon input-icon-right">
                                                        <input type="password" name="passc" class="form-control" placeholder="重复密码" />
                                                    </span>
                                                </label>

                                                <div class="space"></div>
                                                <input type="hidden" name="code" value="<?php echo $code; ?>" />
                                                <input type="hidden" name="cid" value="<?php echo $cid; ?>" />

                                                <div class="clearfix">

                                                    <button id="submitbtn" type="button" class="width-35 pull-right btn btn-sm btn-primary">
                                                        <i class="ace-icon fa fa-key"></i>
                                                        <span class="bigger-110">修改</span>
                                                    </button>
                                                </div>

                                                <div
                                                    class="space-4"></div>
                                            </fieldset>
                                        </form>

                                    </div><!-- /.widget-main -->

                                </div><!-- /.widget-body -->
                            </div><!--
                            /.login-box
                            -->
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.main-content -->
            </div><!-- /.main-container -->
<script language="javascript">
    var _error = "<?php echo $error; ?>";
$(document).ready(function(){
    $('#submitbtn').click(function(){
        $('#reform').submit();
    });
    if(_error) {
        show_notify(_error);
    }
});
function show_notify(msg, life){
        if(!life || life ==undefined)
                    life = 1000;
            $.jGrowl(msg, {'life' : life});
}

</script>

        </body>
    </html>
