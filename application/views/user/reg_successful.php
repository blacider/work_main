<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <script>
            var _hmt = _hmt || [];
        </script>
        <title> 云报销 - 对报销的怨言，到此为止。</title>
        <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="baidu-site-verification" content="74glnE71aV" />
        <meta name="description" content="最好用的财务报销审批系统。对报销的怨言，到此为止。">
        <meta name="keywords" content="云报销,报销,云报销,报销,财务审批,审批,财务,办公,发票,贴发票,贴票,成本,金额">
        <meta name="format-detection" content="telephone=no" />
        <meta property="wb:webmaster" content="a239efc5a51c65f0" />
        <link rel="stylesheet" href="/static/css/reset.css">
        <link rel="stylesheet" href="/static/css/mod/login/index.css">
        <script src="/static/js/jquery.min.js"></script>
        <!--[if lt IE 9]>
        <script src="static/js/respond.min.js"></script>
        <script src="/static/js/mod/login/placeholder.js"></script>
        <link rel="stylesheet" type="text/css" href="static/css/ie.css">
        <![endif]-->
        <!--[if gte IE 9]>
        <link rel="stylesheet" type="text/css" href="static/css/notie.css">
        <![endif]-->
        <!--[if !IE]><!-->
        <link rel="stylesheet" type="text/css" href="static/css/notie.css">
        <!--<![endif]-->
        <style>
        #mainContent {
        	text-align: center;
        	max-width: 480px;
        	margin: 100px auto;
        }
        #mainContent h1 {
        	color: #ff575b;
        }
        #mainContent .thanks {
        	text-indent: 28px;
        	font-size: 14px;
        	color: #666;
        	display: inline-block;
		    margin-bottom: 15px;
		    text-align: left;
		    vertical-align: top;
		    padding: 0 20px;
        }
        #mainContent .thanks span {
			display: block;
			margin: 5px 0;
			vertical-align: baseline;
			line-height: 15px;
        }
        #mainContent .thanks span a {
			text-indent: 48px;
			text-decoration: none;
			line-height: 20px;
			color: #666;

        }
        img.logo {
        	border-radius: 100%;
        	overflow: hidden;
        	width: 80px;
        }

        img.action-icon{
        	margin-top: 40px;
        	border-radius: 100%;
        	overflow: hidden;

        }
		img.action-icon:hover {
			background: #F5F5F5;
		}
        </style>
    </head>
    <body>
		<div id="mainContent">
			<a href="/"><img class="logo" src="/static/logo.png" alt=""></a>
			<h1>注册完成！</h1>
			
			<p class="thanks">
			<span>
		       	<a>
		       		感谢试用 『云报销』，试用期间您将免费使用产品的部分功能。
				如果您希望进一步了解 云报销，请与我们的客服联系。
				<br>
		       	</a>
			</span>
			</p>
			<p style="text-align: center; margin-bottom: 20px">云报销，对报销的怨言到此为止！</p>
			<div class="code">
				<p style="margin-bottom: -20px; position: relative; z-index: 99">请使用手机扫码下载 云报销手机客户端</p>
				<img src="/static/img/download.png" style="width:266px; height:266px;">
			</div>
			<div>
				<a href="/"><img class="action-icon rightd" src="/static/img/mod/login/right.png" alt="right" height="53" width="53"></a>
				<a style="display: block;" href="/">进入云报销</a>
			</div>
		</div>
        <?php if(!$has_attacker) { ?>
        <!-- 百度统计 -->
        <div style="display: none;">
        <script>
        var _hmt = _hmt || [];
        (function() {
          var hm = document.createElement("script");
          hm.src = "//hm.baidu.com/hm.js?777289b210223dd4e237d8e2089250fd";
          var s = document.getElementsByTagName("script")[0]; 
          s.parentNode.insertBefore(hm, s);
        })();
        </script>
        </div>
        <?php } ?>
        <?php if(!$lte_ie8) {?>
        <?php get_sub_widget('module/widgets/meiqia'); ?> 
        <?php } ?>
    </body>
</html>
