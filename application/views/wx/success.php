<!DOCTYPE html>
<html>
<head>
	<title>云报销 - 下载</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=yes">
  <link rel="shortcut icon" href="http://www.yunbaoxiao.com/favicon.ico">
  <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" type="text/css" href="/static/wx/css/normalize.css">
    <link rel="stylesheet" type="text/css" href="/static/wx/css/index.css">
    <script type="text/javascript" src="/static/wx/js/jquery.js"></script>
    <script type="text/javascript" src="/static/wx/js/index.js"></script>
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
  <div class="block1">
    <div class="main-block">
        <div style="width:100%">
        <?php
if($msg == "") {
        ?>
            <img style="width:100%" src="http://www.yunbaoxiao.com/img/text_title_42@2x.png">
<?php
} else {
?>
<p style="font-size:14px;">你已加入了：</p>
<h1 style="font-size:25px;"><?php echo $msg; ?></h1>
<p style="font-size:14px;">请下载「云报销」，和你的同事一起，开启全新的报销体验。</p>
<?php
}
?>
        </div>
      <div id="download" style="display:block" onclick="download()">
        <div class="content">
          <div class="android android-img">下载安装</div>
          <div class="ios ios-img">App Store 下载</div>
        </div>
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
        <li><a href="https://www.yunbaoxiao.com/contact.html">关于我们</a></li>
        <li><a href="https://www.yunbaoxiao.com/help.html">帮助中心</a></li>
        <li><a href="https://www.yunbaoxiao.com/joinus.html">加入我们</a></li>
      </ul>
      </div>
      <div class="record">
      <p class="footer-text">京ICP备14046885号-2</p>
      </div>
    </div>
  </div>
  </div>
</body>
</html>
