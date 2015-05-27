<!DOCTYPE html>
<html>
<head>
    <title>云报销 - 申请加入公司</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=yes">
    <link rel="stylesheet" type="text/css" href="/static/wx/css/normalize.css">
    <link rel="stylesheet" type="text/css" href="/static/wx/css/index.css">
    <script type="text/javascript" src="/static/wx/js/jquery.js"></script>
<script language="javascript">
    var __BASEURL = "<?php echo base_url(); ?>";
</script>
    <script type="text/javascript" src="/static/wx/js/index.js"></script>
</head>
<body>
  <div id="winxin">
    <div class="triangle-up"></div>
    <div class="weixin-content">
      <h2 class="ios safari">请在菜单中选择：&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp使用Safari打开</h2>
      <h2 class="android explore">请在菜单中选择:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp使用浏览器打开</h2>
    </div>
  </div>
  <div class="block1">
    <div class="main-block">
      <!--alvayang -->
      <p><?php echo $invitor; ?> 邀请你加入：</p>
      <h1><?php echo $gname; ?></h1>
      <p>请完善个人信息</p>
      <form onsubmit="return check()">
        <div class="form-name">
          <p>姓名</p>
          <input id="name" name="name" type="text">
        </div>
        <!--
        <div class="form-email">
          <p>公司邮箱</p>
          <input id="email" name="email" type="text">
          <p id="error">请输入姓名</p>
        </div>
        -->
        <input type="hidden" name="gid" value="<?php echo $gid; ?>">
        <input type="hidden" name="uid" value="<?php echo $uid; ?>">
        <input type="submit" value="确认加入">
      </form>
      <div id="download" onclick="download()">
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
        <p class="footer-text">© 2014-2015 如数科技有限公司 / All Rights Reserved</p>
      </div>
      <div class="footer-link">
        <ul>
  			<li><a href="http://www.cloudbaoxiao.com/contact.html">关于我们</a></li>
  			<li><a href="http://www.cloudbaoxiao.com/help.html">帮助中心</a></li>
  			<li><a href="http://www.cloudbaoxiao.com/joinus.html">加入我们</a></li>
      </ul>
      </div>
      <div class="record">
      <p class="footer-text">京ICP备 14046885号-2</p>
      </div>
    </div>
  </div>
</body>
</html>
