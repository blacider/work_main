<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
  <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" type="text/css" href="/static/css/login.css">
    <link rel="stylesheet" type="text/css" href="/static/css/normalize.css">
    <script type="text/javascript" src="/static/js/jquery.min.js"></script>
    <!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
      <script>
      $(function(){
      $('.login-button-div').click(function(event) {
          /* Act on the event */
          this.getElementsByTagName('input')[0].click();
      });
      });
      </script>
      <link rel="stylesheet" type="text/css" href="/static/css/ie.css">
    <![endif]-->
    <!--[if gte IE 9]>
      <link rel="stylesheet" type="text/css" href="/static/css/notie.css">
    <![endif]-->
    <!--[if !IE]><!-->
      <link rel="stylesheet" type="text/css" href="css/notie.css">
    <!--<![endif]-->
    <script type="text/javascript" src="js/index.js"></script>
    <script type="text/javascript" src="js/login.js"></script>
</head>
<body>
  <div class="header">
  	<div class="main-block">
  		<a href="//www.cloudbaoxiao.com"><div class="home-logo"></div></a>
  		<div class="header-link">
  			<ul>
        <!--
  				<li><a href="#price">价格</a></li>
  				<li><a href="#">Blog</a></li>
  				<li id="min-margin"><a href="">登录</a></li> -->
  				<li class="header-button ie-button1"><a href="//www.cloudbaoxiao.com/#sign">申请试用</a></li>
  			</ul>
  		</div>
  	</div>
  </div>
  <div class="block1 block">
    <div class="main-block">
      <div class="login">
        <div class="login-left"><br>对报销的怨言，<br>到此为止</div>
        <div class="login-right">
          <form id="form-login" onsubmit="return checkLogin()">
            <div class="form-phone">
              <span>手机号/邮箱</span>
              <span class="error">请输入手机或邮箱</span>
              <span class="error">手机或邮箱输入格式有误</span>
              <input type="text" name="phone">
            </div>
            <div class="form-password">
              <span>密码</span>
              <span class="error">请输入密码</span>
              <input type="password" name="password">
            </div>
            <div class="form-submit login-button-div"><input type="submit" value="登录">
            <p class="button-text">登录</p></div>
            <a onclick="findPassword()" class="find-password">找回密码</a>
          </form>
          <form id="form-phone" onsubmit="return checkPhone()">
            <div class="form-phone">
              <h1>忘记密码</h1>
              <span>输入手机号/邮箱</span>
              <span class="error">请输入手机或邮箱</span>
              <span class="error">手机或邮箱输入格式有误</span>
              <span class="error">用户不存在</span>
              <input type="text" name="phone">
            </div>
            <div class="form-submit login-button-div"><input type="submit" value="找回密码">
            <p class="button-text">找回密码</p></div>
            <a onclick="backLogin()" class="find-password">返回登录</a>
          </form>
          <form id="form-phone-step1" onsubmit="return checkPhone2()">
            <div class="form-phone">
              <h1>忘记密码</h1>
              <span>输入手机号/邮箱</span>
              <span class="error"></span>
              <input type="text" name="phone" readonly="readonly">
            </div>
            <div class="form-code">
              <span>输入验证码</span>
              <span class="error">验证码不正确</span>
              <input type="text" name="code">
            </div>
            <div id="send-again">重新发送 60</div>
            <div class="form-submit login-button-div"><input type="submit" value="下一步">
            <p class="button-text">下一步</p></div>
            <a onclick="backStep1()" class="find-password">上一步</a>
          </form>
          <form id="form-phone-step2" onsubmit="return checkPhone3()">
            <div class="form-password">
              <h1 id="step2-title">忘记密码</h1>
              <span>新密码</span>
              <span class="error">请输入密码</span>
              <input type="password" name="password">
            </div>
            <div class="form-password">
              <span>重新输入密码</span>
              <span class="error">两次输入不一致</span>
              <input type="password" name="password2">
            </div>
            <div class="form-submit login-button-div">
            <input type="submit" value="修改密码">
             <p class="button-text">修改密码</p></div>
            <a onclick="backStep2()" class="find-password">上一步</a>
          </form>
          <div id="email">
            <p>请到 abjkl@163.com查阅来自云报销的邮件，从邮件重设你的密码。</p>
            <div><a href="index.html">返回首页</a></div>
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
  			<li><a href="#">关于我们</a></li>
  			<li><a href="#">帮助中心</a></li>
  			<li><a href="#">加入我们</a></li>
  		</ul>
  	  </div>
  	  <div class="record">
  		<p class="footer-text">京ICP备 14046885号-2</p>
  	  </div>
  	</div>
  </div>
</body>
</html>
