<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>云报销企业微信钱包转账</title>
	<!-- 数字证书 -->
	<script>
		window.__CBX_UTOKEN__ = "<?php echo $CBX_UTOKEN['0']; ?>".replace('X-REIM-JWT: ', '');
	</script>

	<!-- basic css resource here -->
	<link rel="stylesheet" href="/static/css/widgets/loading-default.css"/>
	<link rel="stylesheet" href="/static/css/mod/bills/paylist.css">

</head>
<body ng-app="reimApp">
	<div class="mod mod-reim-paylist" ng-controller="PayListController">
        <div class="ui-loading-layer" ng-if="!isLoaded">
            <div class="ui-loading-icon"></div>
        </div>
        <div class="company">
        	
        </div>
	</div>
	<!-- basic js resource here -->

	<script src="/app/libs/angular/angular.min.js"></script>
	<script src="/static/js/libs/jquery/jquery.min.js"></script>
	<script src="/static/js/libs/underscore.js"></script>
	<script src="/static/js/libs/utils.js"></script>
	<script src="/static/js/mod/bills/paylist.js"></script>
	
</body>
</html>