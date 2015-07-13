<!DOCTYPE html>
<html lang="en">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<head>
<title>404 Page Not Found</title>
<style type="text/css">

::selection{ background-color: #E13300; color: white; }
::moz-selection{ background-color: #E13300; color: white; }
::webkit-selection{ background-color: #E13300; color: white; }

body {
	background-color: #fff;
	margin: 40px;
	font: 13px/20px normal Helvetica, Arial, sans-serif;
	color: #4F5155;
}

a {
	color: #003399;
	background-color: transparent;
	font-weight: normal;
}

h1 {
	color: #444;
	background-color: transparent;
	border-bottom: 1px solid #D0D0D0;
	font-size: 19px;
	font-weight: normal;
	margin: 0 0 14px 0;
	padding: 14px 15px 10px 15px;
}

code {
	font-family: Consolas, Monaco, Courier New, Courier, monospace;
	font-size: 12px;
	background-color: #f9f9f9;
	border: 1px solid #D0D0D0;
	color: #002166;
	display: block;
	margin: 14px 0 14px 0;
	padding: 12px 10px 12px 10px;
}

#container {
	margin: 10px;
	border: 1px solid #D0D0D0;
	-webkit-box-shadow: 0 0 8px #D0D0D0;
}

p {
	margin: 12px 15px 12px 15px;
}
</style>
</head>
<body>
	<div id="container" style="display:none">
        <h1><?php echo $heading; ?></h1>
		<?php echo $message; ?>

        <section >
            <img src="/static/images/icon_404.png" alt="I swear!" >
        </section>

    </div>
    <div style="position:absolute; top:0; right:0; bottom:0; left:0; width:50%; height:50%; margin:auto; color:white; line-height:20px; text-align:center;">
    <div align="center">
        <img src="/static/images/icon_404.png" />
    </div>
    <div align="center" style="color:#ff575b">呃，页面暂时不能访问</div>

    <div align="center" style="color:#ff575b">我们正在努力抢修</div>
</div>
</body>
</html>
