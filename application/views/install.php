<!DOCTYPE html>
<html lang="zh">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <title>云报销-安装</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, minimal-ui">
        <link rel="stylesheet" href="/static/assets/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="/static/assets/css/font-awesome.min.css"/>
        <link rel="stylesheet" href="/static/assets/css/ace-fonts.css"/>
        <link rel="stylesheet" href="/static/assets/css/ace-rtl.min.css"/>
        <link rel="stylesheet" href="/static/assets/css/ace.onpage-help.css"/>
        <link rel="stylesheet" href="/static/assets/css/ace.min.css" id="main-ace-style"/>
        <style>
            .gray { 
                -webkit-filter: grayscale(100%); 
                -moz-filter: grayscale(100%); 
                -ms-filter: grayscale(100%); 
                -o-filter: grayscale(100%); 
                filter: grayscale(100%); 
                filter: gray; 
            } 
        </style>
<script type="text/javascript">
window.jQuery || document.write("<script src='/static/assets/js/jquery.min.js'>" + "<" + "/script>");
if ('ontouchstart' in document.documentElement) document.write("<script src='/static/assets/js/jquery.mobile.custom.min.js'>" + "<" + "/script>");
</script>

    </head>
    <body class="no-skin">
        <div class="main-container">
            <div class="main-content">
                <div class="page-content">
                    <div class="page-content-area">
                        <div class="col-xs-12">
                            <!-- PAGE CONTENT BEGINS -->
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 widget-container-col ui-sortable" id="ios_form">
                                    <div class="widget-box widget-color-red">
                                        <div class="widget-header">
                                            <h5 class="widget-title bigger lighter">
                                                <i class="ace-icon fa fa-apple bigger-110"></i>
                                            </h5>
                                        </div>

                                        <div class="widget-body">
                                            <div class="widget-main">
                                                <div class="center">
                                                    <a href="itms-services://?action=download-manifest&url=https://reiminstall.sinaapp.com/reim.plist" >
                                                        <img src='/static/logo.png' >
                                                    </a>
                                                </div>
                                            </div>

                                            <div>
                                                <a href="itms-services://?action=download-manifest&url=https://admin.cloudbaoxiao.com/static/reim.plist" class="btn btn-block btn-success ios_down">
                                                    <i class="ace-icon fa fa-cloud-download bigger-110"></i>
                                                    <span>下载</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- #section:custom/widget-box -->
                                </div><!-- /.span -->


                                <div class="col-xs-12 col-sm-6 widget-container-col ui-sortable" id="android_form">
                                    <div class="widget-box widget-color-red">
                                        <div class="widget-header">
                                            <h5 class="widget-title bigger lighter">
                                                <i class="ace-icon fa fa-android bigger-110"></i>
                                            </h5>
                                        </div>

                                        <div class="widget-body">
                                            <div class="widget-main">
                                                <div class="center">
                                                    <a href="#" >
                                                        <img src='/static/logo.png' >
                                                    </a>
                                                </div>
                                            </div>

                                            <div>
                                                <a href="/release/android/reim.apk" class="btn btn-block btn-success">
                                                    <i class="ace-icon fa fa-cloud-download bigger-110"></i>
                                                    <span>下载</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- #section:custom/widget-box -->
                                </div><!-- /.span -->



                            </div><!-- /.row -->
                        </div>
                    </div>
                </div><!-- PAGE CONTENT ENDS -->
            </div>
        </div>

        <div id="modal-form" class="modal in" tabindex="-1" aria-hidden="false" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">×</button>
                        <h5 class="blue bigger">请用浏览器打开</h5>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12">
                                <label>微信不让下载呀，请你用浏览器打开吧</label>
                                <label>为啥不给你指引？因为我特马只是一只程序猿呀，我特马不会做设计呀!T_T</label>
                                <div class="space"></div>
                                <label>右上角 --> 在浏览器打开 --> 妥</label>

                            </div>

                        </div>
                    </div>
            </div>
        </div>

    </body>
<script language="javascript" src="/static/ace/js/bootstrap.min.js"></script>
<script language="javascript">
$(document).ready(function(){
    var ua = navigator.userAgent.toLowerCase();
    if (/iphone|ipod|ipad/.test(ua)) {
        $('#android_form').hide();
    } else if (/android/.test(ua)) {
        $('#ios_form').hide();
    }
    $('.ios_down').click(function(){
    var ua = navigator.userAgent.toLowerCase();
    if (/iphone|ipod|ipad/.test(ua)) {
        alert("find");
        if(/micromessenger/.test(ua)){
            try{
            $('#modal-form').modal('show');
            }catch(e){
            }
        }
    }
    });
});

</script>
</html>
