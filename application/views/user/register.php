<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <title>云报销,让报销简单点</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <link rel="shortcut icon" href="/static/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="/static/css/login.css">
    <link rel="stylesheet" type="text/css" href="/static/css/normalize.css">
    <script type="text/javascript" src="/static/js/jquery.js"></script>
    <!--[if lt IE 9]>
      <script src="/static/js/respond.min.js"></script>
      <link rel="stylesheet" type="text/css" href="/static/css/ie.css">
      <script language="javascript">
      

      $(document).ready(function(){
        $(".block1").css("height","500px");
        $("input[type='submit']").css("visibility","hidden");
        $("#button-div").css("cursor","pointer");
        $("#button-div").click(function(){
          this.firstChild.click();
        });
      });
      </script>
    <![endif]-->
    <!--[if gte IE 9]>
      <link rel="stylesheet" type="text/css" href="/static/css/notie.css">
    <![endif]-->
    <!--[if !IE]><!-->
      <link rel="stylesheet" type="text/css" href="/static/css/notie.css">
    <!--<![endif]-->
<script language="javascript">
    var __BASE = "<?php echo base_url(); ?>";
</script>
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
          <form id="form-login" onsubmit="return checkLogin()" action="<?php echo base_url('login/dologin');  ?>" method="post" style="display:none;">
            <div class="form-phone">
              <span>手机号/邮箱</span>
              <span class="error">请输入手机或邮箱</span>
              <span class="error">手机或邮箱输入格式有误</span>
              <input type="text" name="u">
            </div>
            <div class="form-password">
              <span>密码</span>
              <span class="error">请输入密码</span>
              <input type="password" name="p">
            </div>
            <div id="button-div" class="form-submit ie-button1"><input type="submit" value="登录"></div>
            <a onclick="findPassword()" class="find-password">找回密码</a>
          </form>
          <form id="form-phone" onsubmit="return checkPhone()">
            <div class="form-phone">
              <h1>忘记密码</h1>
              <span>输入手机号/邮箱</span>
              <span class="error">请输入手机或邮箱</span>
              <span class="error">手机或邮箱输入格式有误</span>
              <span class="error">用户不存在</span>
              <span id="cerror" class="error" ></span>
              <input type="text" name="phone">
            </div>
            <div id="button-div" class="form-submit ie-button1"><input type="submit" value="找回密码"></div>
            <a onclick="backLogin()" class="find-password">返回登录</a>
          </form>
          <form id="form-phone-step1" onsubmit="return checkPhone2()">
            <div class="form-phone">
              <h1>忘记密码</h1>
              <span>输入手机号/邮箱</span>
              <span class="error"></span>
              <span id="verror" class="error"></span>
              <input type="text" name="phone" readonly="readonly">
            </div>
            <div class="form-code">
              <span>输入验证码</span>
              <span class="error">验证码不正确</span>
              <input type="text" name="code">
            </div>
            <div id="send-again">重新发送 60</div>
            <div id="button-div" class="form-submit ie-button1"><input type="submit" value="下一步"></div>
            <a onclick="backStep1()" class="find-password">上一步</a>
          </form>
          <form id="form-phone-step2" onsubmit="return register()" style="display:block;" method="POST" action="<?php echo base_url('register/doregister'); ?>">
            <div class="form-password">
<?php
$placeholder = '';
if($name){
    $placeholder =  $name;
}

?>
              <span>密码</span>
              <span class="error">请输入密码</span>
              <input type="password" id="pass" name="password">
            </div>
            <div class="form-password">
              <span>重新输入密码</span>
              <span class="error">两次输入不一致</span>
              <input type="password" id="pass2" name="password2">
            </div>
              <input type="hidden" id="phone_hidden" />
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
        <p class="footer-text">©2016 如数科技有限公司 / All Rights Reserved</p>
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
