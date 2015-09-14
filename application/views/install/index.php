<!DOCTYPE html>
<html>
<head>
  <title>云报销 - 下载</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=yes">
  <link rel="shortcut icon" href="http://www.cloudbaoxiao.com/favicon.ico">
  <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" type="text/css" href="/static/wx/css/normalize.css">
    <link rel="stylesheet" type="text/css" href="/static/wx/css/index.css">
    <script type="text/javascript" src="/static/wx/js/jquery.min.js"></script>
    <!-- <script type="text/javascript" src="/static/wx/js/index.js"></script> -->
<script language="javascript">
    var __BASEURL = "<?php echo base_url(); ?>";
</script>
</head>
<body>
  <div id="winxin">
    <div class="triangle-up"></div>
    <div class="weixin-content">
      <h2 class="ios safari">请在菜单中选择：&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp使用Safari打开</h2>
      <h2 class="android explore">请在菜单中选择:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp使用浏览器打开</h2>
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
            <img style="width:100%" src="http://www.cloudbaoxiao.com/img/text_title_42@2x.png">
        </div>
      
      <div id="download pc" style="" onclick="download()">
            <div class="pc">
                <img src="/static/img/download.png" style="width:160px;height:160px;">
            <div class="">扫描即可下载 iOS、Android 客户端</div>
        </div>
      </div>
    </div>
  </div>
  <div class="footer">
    <div class="main-block">
      <div class="copyright">
        <p class="footer-text">© 2014-2015 如数科技有限公司 / All Rights Reserved</p>
      </div>
      <div class="footer-link">
        <ul>
        <li><a href="https://www.cloudbaoxiao.com/contact.html">关于我们</a></li>
        <li><a href="https://www.cloudbaoxiao.com/help.html">帮助中心</a></li>
        <li><a href="https://www.cloudbaoxiao.com/joinus.html">加入我们</a></li>
      </ul>
      </div>
      <div class="record">
      <p class="footer-text">京ICP备 14046885号-2</p>
      </div>
    </div>
  </div>
  </div>
<script language="javascript">
   $(document).ready(function() {
  /* Act on the event */
  $('.contain').css('height', String(document.body.scrollHeight));
  /*单页面所做的改变*/
  
  $('body').scrollTop(0);
    $('#block1').css({'height': document.body.scrollHeight + 'px', 'min-height' : document.body.scrollHeight + 'px'});
});

function download() {
    //window.location.href = '';
}
</script>
</body>
</html>

