<!DOCTYPE html>
<html lang="en" style="font-size: 16px;">
<head>
	<meta charset="UTF-8">
	<title>云报销－微信钱包授权</title>
	<!-- 数字证书 -->
    <script>
        window.__CLIEN_ID__ = "<?= $client_id ?>";
        window.__CLIEN_SECRET__ = "<?= $client_secret ?>";
    </script>

    <!-- basic css resource here -->
	<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
	<meta name="format-detection" content="telephone=no">
	<meta name="apple-mobile-web-app-status-bar-style" content="white">
	<meta name="apple-mobile-web-app-capable" content="yes">

	<link rel="shortcut icon" href="/static/logo.png"/>
	<link rel="bookmark" href="/static/logo.png"/>

	<link rel="stylesheet" href="/static/css/mod/mobile/wallet.css">
	<script>

	var _CONST_API_DOMAIN_ = "<?php echo $api_url_base; ?>";

	window['_weixin_data_'] = {
		title: "", // 分享标题
		desc: "", // 分享描述
		link: location.href, // 分享链接
		imgUrl: '', // 分享图标
		type: "link", // 分享类型,music、video或link，不填默认为link
		dataUrl: ""
	};

	</script>
</head>
<body>
	<div class="main">
		<header>
			<img src="/static/img/mod/mobile/logo@2x.png" alt="">
			<div class="declare">
				<h2>微信钱包授权</h2>
				<p>说明：仅限于公司财务转账使用</p>
			</div>
		</header>
		<div class="profile">
			<h2>当前用户信息</h2>
			<div class="row">
				<div class="col">
					微信昵称：<span class="wx-nickname"></span>
				</div>
				<!-- <div class="col line"></div>
				<div class="col">
					微信号：<span class="wx-account"></span>
				</div> -->
			</div>
			<div class="row three">
				<div class="col">姓名：<span class="nickname"></span></div>
				<div class="col line"></div>
				<div class="col">职位：<span class="job"></span></div>
			</div>
			<div class="row ">
				<div class="col">公司：<span class="company"></span></div>
			</div>
		</div>
		<div class="input-wrap">
			<div class="for-phone">
				已向您的<span class="mode"></span>：<span class="receiver"></span>
			</div>
			<div class="code-input">
				<div class="input">
					<input class="code" type="number">
				</div>
				<button class="btn-send-code">发送验证码</button>
			</div>
			<h2 class="fail">验证码错误</h2>
			<button class="btn-submit">提交</button>
		</div>

	</div>

	<script src="/static/js/libs/zepto.min.js"></script>
	<script src="/static/js/libs/underscore.js"></script>
	<script src="/static/js/libs/jweixin-1.0.0.js"></script>
	<script src="/static/js/libs/underscore.deferred.js"></script>
	<script>
		$.Deferred = _.Deferred;
	</script>
	<script src="/static/js/libs/utils.js"></script>
	<script src="/static/js/libs/debug-console.js"></script>
	<script src="/static/js/mod/mobile/wallet.js?_r=12312"></script>

</body>
</html>
