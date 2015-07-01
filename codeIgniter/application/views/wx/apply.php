<!DOCTYPE html>
<html>
    <head>
        <title>云报销 - 申请加入公司</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="/static/wx/css/normalize.css">
        <link rel="stylesheet" type="text/css" href="/static/wx/css/index.css">
         <meta name="viewport" content="width=960" />
         <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<script language="javascript">
var __BASEURL = "<?php echo base_url(); ?>";
</script>
<script type="text/javascript" src="/static/wx/js/jquery.js"></script>
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
    <div class="contain">
        <div class="block1">
            <div class="main-block">
                <!--alvayang -->
                <p style="font-size:14px;">你的同事 <?php echo $invitor; ?> 邀请你加入：</p>
                <h1 style="font-size:25px;"><?php echo $gname; ?></h1>
                <p style="font-size:14px;">请完善个人信息，以便管理员确认你的身份</p>
                <form onsubmit="return check()">
                    <div class="form-name">
                        <input id="name" name="name" style="color:grey" value="请输入真实姓名" type="text" onfocus="this.value='';this.style.color = 'black'" onblur="if(this.value == ''){this.value = '请输入真实姓名';this.style.color = 'grey'}">
                    </div>
                    <p id="error">请输入姓名</p>
                    <input type="hidden" name="gid" value="<?php echo $gid; ?>">
                    <input type="hidden" name="uid" value="<?php echo $uid; ?>">
                    <input type="submit" value="确认加入" onclick="if($('#name').val() == '请输入真实姓名'){$('#name').val('')}">
                </form>
                <div id="download" onclick="download()">
                    <div class="content">
                        <div class="android android-img">下载安装</div>
                        <div class="ios ios-img">App Store 下载</div>
                    </div>
                </div>
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
                    <p class="footer-text">京ICP备14046885号-2</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
