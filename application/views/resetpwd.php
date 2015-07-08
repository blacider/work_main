<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <title>云报销,让报销简单点</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <link rel="shortcut icon" href="/static/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="/static/css/login.css">
    <link rel="stylesheet" type="text/css" href="/static/css/normalize.css">
    <!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
      <link rel="stylesheet" type="text/css" href="/static/css/ie.css">
    <![endif]-->
    <!--[if gte IE 9]>
      <link rel="stylesheet" type="text/css" href="/static/css/notie.css">
    <![endif]-->
    <!--[if !IE]><!-->
      <link rel="stylesheet" type="text/css" href="/static/css/notie.css">
    <!--<![endif]-->
<script language="javascript">
    var __BASE = "<?php echo base_url(); ?>";
    var _error = "";
</script>
    <script type="text/javascript" src="/static/js/jquery.js"></script>
    <script type="text/javascript" src="/static/js/index.js"></script>
    <script type="text/javascript" src="/static/js/login.js"></script>
</head>
<body>
  <div class="header">
  	<div class="main-block">
        <a href="http://www.yunbaoxiao.com">
            <div class="home-logo"> </div>
        </a>
  		<div class="header-link">
  			<ul>
                <!-- 
  				<li><a href="#">Blog</a></li>
  				<li id="min-margin"><a href="#">登录</a></li>
                -->
  				<li class="header-button ie-button1"><a href="http://www.yunbaoxiao.com/#sign">申请试用</a></li>
  			</ul>
  		</div>
  	</div>
  </div>
  <div class="block1 block">
    <div class="main-block">
      <div class="login">
          <div class="login-left" style="padding-top:36px;font-size:25px;"><br>为邮箱设置密码<br> <span style="color:#ff575b"><?php echo $name; ?></span><br></div>
        <div class="login-right">
          <form id="form-phone-step2" style="display:block;" method="POST" action="<?php echo base_url('resetpwd/doupdate'); ?>">
            <div class="form-password">
<?php
$placeholder = '';
if($name){
    $placeholder =  $name;
}

?>
              <span>密码</span>
              <span class="error">请输入密码</span>
              <input type="password" id="pass" name="passc">
            </div>
            <div class="form-password">
              <span>重新输入密码</span>
              <span class="error">两次输入不一致</span>
              <input type="password" id="pass2" name="pass">
            </div>
              <input type="hidden" id="phone_hidden" />
              <input type="hidden" name="code" value="<?php echo $code; ?>" />
                                                <input type="hidden" name="cid" value="<?php echo $cid; ?>" />
              <input type="hidden" id="code_hidden" />
            <div id="button-div" class="form-submit ie-button1"><input type="submit" value="注册"></div>
    <input type="hidden" name='u' class="form-control" value="<?php echo $placeholder; ?>">
            <!-- <a onclick="backStep2()" class="find-password">上一步</a> -->
          </form>
          <div id="email">
            <p></p>
            <div><a href="index.html">注册</a></div>
          </div>
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
  			<li><a href="http://www.yunbaoxiao.com/contact.html">关于我们</a></li>
  			<li><a href="http://www.yunbaoxiao.com/help.html">帮助中心</a></li>
  			<li><a href="http://www.yunbaoxiao.com/joinus.html">加入我们</a></li>
  		</ul>
  	  </div>
  	  <div class="record">
  		<p class="footer-text">京ICP备 14046885号-2</p>
  	  </div>
  	</div>
  </div>
</body>
</html>
