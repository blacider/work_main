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
      <div id="download" class="android" style="" onclick="download()">
        <div class="content">
          <div class="android android-img">下载安装</div>
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
    $(document).ready(function(){
    /* Act on the event */
    $('.contain').css('height', String(document.body.scrollHeight));
    $('#download ').css('display', 'block');
    $('.android').show();
    $('.android').css('display', 'block');
    $('.ios').css('display', 'none');
    $('.pc').css('display', 'none');
    /*单页面所做的改变*/
    $('body').scrollTop(0);
    $('#block1').css({'height': document.body.scrollHeight + 'px', 'min-height' : document.body.scrollHeight + 'px'});
    });

    function download() {
      if(isWeixin()) {
        $('#winxin').css('display', 'block');
        setTimeout(function(){
          $('.block1')[0].onclick = function() {
              $('#winxin').css('display', 'none');
              $('.block1')[0].onclick = function() {
                return;
              }
            }
        },50);
    } else{
        window.location.href = 'https://files-cloudbaoxiao-com.alikunlun.com/release/android/1.2.7/reim.apk'; 
        }
    }

    function isWeixin(){
    var ua = navigator.userAgent.toLowerCase();
    if(ua.match(/MicroMessenger/i)=="micromessenger") {
      return true;
    } else {
      return false;
    }
    }
</script>
</body>
</html>
