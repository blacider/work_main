<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <script>
            var _hmt = _hmt || [];
        </script>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>云报销 - <?php echo $title; ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
        <meta name="renderer" content="webkit">
        <link rel="shortcut icon" href="/static/favicon.ico" />
        <meta charset="utf-8"/>
        <meta name="description" content="云报销 - 对报销的怨言，到此为止。云报销是一款支持手机端和web端的报销工具，支持安卓报销 、苹果端报销和Web报销，支持审批和费控的管理。员工、财务人员和经理均可使用，轻松代替纸质单据和 Excel 表格，优化整个公司的费用体系和财务流程，帮助企业提高办公效率">
        <meta name="keywords" content="云报销,简单报销,易报销,快报销,快速报销,闪电报销,指尖报销,审批,移动审批,在线审批,医保报销,生育报销,各种报销,费用报销,企业报销,财务,财务审批,财务软件,财务系统,财务报销,报销,填报销,差旅,报销单,电子报销单,报销软件,报销系统,报销管理,在线报销,网上报销,手机报销,发票,贴发票,电子发票,云发票,ERP">
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

    <script>
        var __BASE = "<?php echo $base_url; ?>";
        window.__CBX_UTOKEN__ = "<?php echo $CBX_UTOKEN['0']; ?>".replace('X-REIM-JWT: ', '');
        window.__UID__ = "<?php echo $userId; ?>";
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

        if (!window.console || !console.firebug){
            var names = ["log", "debug", "info", "warn", "error", "assert", "dir", "dirxml", "group", "groupEnd", "time", "timeEnd", "count", "trace", "profile", "profileEnd"];

            window.console = {};
            for (var i = 0; i < names.length; ++i)
                window.console[names[i]] = function() {}
        }
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
<script language="javascript" src="/static/ace/js/ace.min.js"></script>
<script language="javascript" src="/static/ace/js/ace-elements.min.js"></script>
<link rel="stylesheet" href="/static/ace/css/ace.onpage-help.css">

<script type="text/javascript"> ace.vars['base'] = '..'; </script>
<script src="/static/ace/js/ace/elements.onpage-help.js"></script>
<script src="/static/ace/js/ace/ace.onpage-help.js"></script>
<script src="/static/third-party/jg/jquery.jgrowl.min.js"></script>
<script src="/static/js/jquery.cookie.js"></script>
<script src="/static/js/libs/utils.js"></script>

<style type="text/css">
    .jGrowl-close {
            line-height: 1em;
    }
    .container {
                max-width: 100%;
            }
</style>
    </head>
    <?php if($browser_not_supported) {?>
    <?php get_sub_widget('module/widgets/ie_lower_version'); ?>
    <?php } ?>
    <body class="skin-0 no-skin" style="font-size: 14px;color: #7F8C8D;">
