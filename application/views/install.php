<!DOCTYPE html>
<html>
<head>
    <title>云报销 - 下载</title>
    <script>
    var _hmt = _hmt || [];
    </script>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=yes">
    <meta name="description" content="云报销 - 对报销的怨言，到此为止。云报销是一款支持手机端和web端的报销工具，支持安卓报销 、苹果端报销和Web报销，支持审批和费控的管理。员工、财务人员和经理均可使用，轻松代替纸质单据和 Excel 表格，优化整个公司的费用体系和财务流程，帮助企业提高办公效率">
        <meta name="keywords" content="云报销,简单报销,易报销,快报销,快速报销,闪电报销,指尖报销,审批,移动审批,在线审批,医保报销,生育报销,各种报销,费用报销,企业报销,财务,财务审批,财务软件,财务系统,财务报销,报销,填报销,差旅,报销单,电子报销单,报销软件,报销系统,报销管理,在线报销,网上报销,手机报销,发票,贴发票,电子发票,云发票,ERP">
    <link rel="shortcut icon" href="http://www.yunbaoxiao.com/favicon.ico">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" type="text/css" href="/static/wx/css/normalize.css">
    <link rel="stylesheet" type="text/css" href="/static/wx/css/index.css">
</head>
<body>
    <div id="winxin">
        <div class="triangle-up"></div>
        <div class="weixin-content">
            <h2 class="safari">请在菜单中选择：<img src="/static/wx/img/explorer-iOS.png" alt="">使用Safari打开</h2>
            <h2 class="explore">请在菜单中选择: <img src="/static/wx/img/explorer-android.png" alt="">使用浏览器打开</h2>
        </div>
    </div>
    <div class="header">
        <div class="main-block">
            <a href="/"><div class="home-logo"></div></a>
        </div>
    </div>
    <div class="contain">
        <div class="block1" style="min-height:500px;">
            <div class="main-block">
                <div style="width:100%">
                    <img style="width:100%" src="/static/img/text_title_42@2x.png">
                </div>
                <!-- android -->
                <a data-href="<?php echo $android_url ?>" class="android btn-download">
                    下载安装
                </a>
                <!-- ios -->
                <a data-href="https://itunes.apple.com/cn/app/yun-bao-xiao-dui-bao-xiao/id1030689407" class="ios btn-download">
                    App Store 下载
                </a>
                
                <!-- pc -->
                <div class="pc">
                    <img src="/static/img/download.png" style="width:160px;height:160px;">
                    <div class="">扫描即可下载 iOS、Android 客户端</div>
                </div>
            </div>
        </div>
        <div class="footer">
            <div class="main-block">
                <div class="copyright">
                    <p class="footer-text">©2016 如数科技有限公司 / All Rights Reserved</p>
                </div>
                <div class="footer-link">
                    <ul>
                        <li><a href="https://www.yunbaoxiao.com/static/html/contact.html">关于我们</a></li>
                    </ul>
                </div>
                <div class="record">
                    <p class="footer-text">京ICP备 14046885号-2</p>
                </div>
            </div>
        </div>
    </div>
    <!-- 百度统计 -->
    <?php if(!$has_attacker) { ?>
    <script>
    var _hmt = _hmt || [];
    (function() {
        var hm = document.createElement("script");
        hm.src = "//hm.baidu.com/hm.js?f3b83c21deaa6cfaa74e7ade7c0418d0";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();
    </script>
    <?php } ?>
    <script type="text/javascript" src="/static/wx/js/jquery.min.js"></script>
    <script type="text/javascript" src="/static/js/libs/detect.js"></script>
    <script type="text/javascript" src="/static/wx/js/index.js"></script>
    <script>
    var uaObject = detect.parse(navigator.userAgent);
    var flag = false;
    if (uaObject['os']['family'] == 'iOS' && uaObject['os']['major'] < 8) {
        setTimeout(function() {
            var tips = '需要iOS8.0或更高版本才能下载并使用 云报销APP，请尝试升级系统版本或与云报销客服联系。';
            $('.btn-download').replaceWith(tips);
        }, 100)
    }
    </script>
    <script>
    $(document).ready(function() {
        $('#block1').css({
            'height': document.body.scrollHeight + 'px',
            'min-height': document.body.scrollHeight + 'px'
        });
    });
    </script>
    <!-- 落地页渠道统计 -->
    <script>
    function getParameterByName(name, url) {
        if (!url) url = window.location.href;
        name = name.replace(/[\[\]]/g, "\\$&");
        var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, " "));
    };
    var _CONST_FR_ = getParameterByName('fr') || 'none';
    _hmt.push('_trackEvent', 'install_page_fr', _CONST_FR_);
    _hmt.push(['_setCustomVar', 1, 'install_page_fr', _CONST_FR_, 1]);
    </script>
    <!-- 渠道判断 -->
    <script>
        if(getParameterByName('channel') == 'inhouse') {
            var inhouseUrl = 'itms-services://?action=download-manifest&url=https://www.yunbaoxiao.com/pub/xreim';
            $('.ios').data('href', inhouseUrl);
        }
    </script>
</body>
</html>