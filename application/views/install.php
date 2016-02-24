<!DOCTYPE html>
<html>
<head>
	<title>云报销 - 下载</title>
  <script>
  var _hmt = _hmt || [];
  </script>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=yes">
  <link rel="shortcut icon" href="http://www.yunbaoxiao.com/favicon.ico">
  <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" type="text/css" href="/static/wx/css/normalize.css">
    <link rel="stylesheet" type="text/css" href="/static/wx/css/index.css">
    <script type="text/javascript" src="/static/wx/js/jquery.min.js"></script>
    <script type="text/javascript" src="/static/wx/js/index.js"></script>
<script>
    var __BASEURL = "<?php echo base_url(); ?>";
    var platform = "<?php echo $platform; ?>";
</script>
</head>
<body>
  <div id="winxin">
    <div class="triangle-up"></div>
    <div class="weixin-content">
      <h2 class="ios safari">请在菜单中选择：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;使用Safari打开</h2>
      <h2 class="android explore">请在菜单中选择: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;使用浏览器打开</h2>
    </div>
  </div>
  <div class="header">
    <div class="main-block">
      <div class="home-logo"></div>
    </div>
  </div>
  <div class="contain">
  <div class="block1" style="min-height:500px;">
    <div class="main-block">
        <div style="width:100%">
            <img style="width:100%" src="/static/img/text_title_42@2x.png">
        </div>
      <?php
        if($platform == 'android') {
      ?>
      <a href="<?php echo $url ?>" id="download" class="android" style="" onclick="download()">
        <div class="content">
          <div class="android android-img">下载安装</div>
        </div>
      </a>
      <?php } else if($platform =='ios') { ?>
      <a href="<?php echo $url ?>" id="download" class="ios" style="" onclick="download()">
        <div class="content">
          <div class="ios ios-img">App Store 下载</div>
        </div>
      </a>
      <?php } else { ?>
      <div id="download pc" style="" onclick="download()">
            <div class="pc">
                <img src="/static/img/download.png" style="width:160px;height:160px;">
            <div class="">扫描即可下载 iOS、Android 客户端</div>
        </div>
      </div>
      <?php } ?>
    </div>
  </div>
  <div class="footer">
    <div class="main-block">
      <div class="copyright">
        <p class="footer-text">©2016 如数科技有限公司 / All Rights Reserved</p>
      </div>
      <div class="footer-link">
        <ul>
        <li><a href="https://www.yunbaoxiao.com/contact.html">关于我们</a></li>
        <li><a href="https://www.yunbaoxiao.com/help.html">帮助中心</a></li>
        <li><a href="https://www.yunbaoxiao.com/joinus.html">加入我们</a></li>
      </ul>
      </div>
      <div class="record">
      <p class="footer-text">京ICP备 14046885号-2</p>
      </div>
    </div>
  </div>
  </div>
<script language="javascript">
    $(document).ready(function(){
        $('#block1').css({'height': document.body.scrollHeight + 'px', 'min-height' : document.body.scrollHeight + 'px'});
    });
</script>
<!-- 百度统计 -->
<div style="display: none;">
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?f3b83c21deaa6cfaa74e7ade7c0418d0";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
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
  _hmt.push('_traceEvent', 'install_page_fr', getParameterByName('fr'));
  _hmt.push(['_setCustomVar', 1, 'install_page_fr', getParameterByName('fr'), 1]);
</script>
</body>
</html>
