<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <script>
            var _hmt = _hmt || [];
        </script>
        <!-- add growing io -->
        <script type='text/javascript'>
        var _vds = _vds || [];
        window._vds = _vds;
        (function() {
            _vds.push(['setAccountId', 'c51af5ab801b549d51103ce73e4ccd6f']);
            (function() {
                var vds = document.createElement('script');
                vds.type = 'text/javascript';
                vds.async = true;
                vds.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'dn-growing.qbox.me/vds.js';
                var s = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(vds, s);
            })();
        })();
        </script>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>云报销 - <?php echo $title; ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
        <meta name="renderer" content="webkit">
        <link rel="shortcut icon" href="/static/favicon.ico" />
        <meta charset="utf-8"/>
        <meta name="description" content="云报销,报销,让报销简单一点儿">
        <meta name="keywords" content="云报销,报销,报销简单点">
        <link rel="icon" href="/static/favicon.ico" />

        <link rel="stylesheet" type="text/css" href="/static/ace/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="/static/ace/css/font-awesome.min.css" />
        <link rel="stylesheet" href="/static/ace/css/jquery-ui.min.css" />
        <link rel="stylesheet" href="/static/ace/css/datepicker.css" />
        <link rel="stylesheet" href="/static/ace/css/ui.jqgrid.css" />
        <link rel="stylesheet" type="text/css" href="/static/css/base/mod.css" />

    <!-- text fonts -->
    <link rel="stylesheet" href="/static/ace/css/ace-fonts.css"/>

    <link rel="stylesheet" href="/static/ace/css/ace.min.css" id="main-ace-style"/>
    <link rel="stylesheet" href="/static/ace/css/ace-skins.min.css"/>

    <link rel="stylesheet" href="/static/third-party/jg/jquery.jgrowl.min.css"/>
    <!-- ace styles -->

    <!--[if lte IE 9]>
    <link rel="stylesheet" href="/static/ace/css/ace-part2.min.css"/>
    <![endif]-->
    <link rel="stylesheet" href="/static/ace/css/ace-rtl.min.css"/>

    <!--[if lte IE 9]>
    <link rel="stylesheet" href="/static/ace/css/ace-ie.min.css"/>
    <![endif]-->
    <link rel="stylesheet" href="/static/ace/css/ace.onpage-help.css"/>
    <!-- text fonts -->
    <link rel="stylesheet" href="/static/css/rushu.css"/>

<script language="javscript">
var __BASE = "<?php echo $base_url; ?>";
</script>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!--[if lt IE 9]>
    <script src="/static/ace/js/html5shiv.js"></script>
    <script src="/static/ace/js/respond.min.js"></script>
    <![endif]-->

    <!--[if !IE]> -->
<script src='/static/ace/js/jquery.min.js'></script>
    <script type="text/javascript">
        window.jQuery || document.write("<script src='/static/ace/js/jquery.min.js'>" + "<" + "/script>");
    </script> 

    <!-- <![endif]-->

    <!--[if IE]>
    <script type="text/javascript">
        window.jQuery || document.write("<script src='/static/ace/js/jquery1x.min.js'>" + "<" + "/script>");
    </script>
    <![endif]-->

    <!--[if lt IE 9]>
    <script src="/static/js/libs/html5.js"></script>
    <![endif]-->

    <script type="text/javascript">
        if ('ontouchstart' in document.documentElement) document.write("<script src='/static/ace/js/jquery.mobile.custom.min.js'>" + "<" + "/script>");
        var __BASE = "<?php echo base_url(); ?>";
    </script>

<!-- page specific plugin scripts -->

<script src="/static/ace/js/jqGrid/jquery.jqGrid.min.js"></script>
<script src="/static/ace/js/jqGrid/i18n/grid.locale-cn.js"></script>

<script language="javascript" src="/static/ace/js/bootstrap.min.js"></script>
<!-- ie7 干脆不加载 -->
<?php if(!$IS_IE_7) {?>
<script language="javascript" src="/static/ace/js/ace.min.js"></script>
<?php } ?>
<script language="javascript" src="/static/ace/js/ace-elements.min.js"></script>
<link rel="stylesheet" href="/static/ace/css/ace.onpage-help.css">

<script type="text/javascript"> ace.vars['base'] = '..'; </script>
<script src="/static/ace/js/ace/elements.onpage-help.js"></script>
<script src="/static/ace/js/ace/ace.onpage-help.js"></script>
<script src="/static/third-party/jg/jquery.jgrowl.min.js"></script>
<script src="/static/js/jquery.cookie.js"></script>
<script src="/static/js/libs/utils.js"></script>

<!--[if IE 6]>
<script src="/static/js/DD_belatedPNG_0.0.8a-min.js"></script>
<script>
DD_belatedPNG.fix('*');
</script>
<![endif]-->

<style type="text/css">
    .jGrowl-close {
            line-height: 1em;
    }
    .container {
                max-width: 100%;
            }
</style>
    </head>
    <!-- IE 7 下 上述ace.min.js 导致报错，此内js无法执行-->
    <?php get_sub_widget('module/widgets/ie_lower_version'); ?>
    <body class="skin-0 no-skin" style="font-size: 14px;color: #7F8C8D;">
