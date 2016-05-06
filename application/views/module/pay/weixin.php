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
        <div class="company sub-mod">
        	<div class="head">账户资金</div>
        	<div class="content">
        		<div class="name"><label for="">企业名称：</label>北京如数科技有限公司</div>
        	</div>
        </div>

        <div class="sub-mod">
	        <div class="head">转账报销单</div>
        	<div class="content" ng-if="reportArray.length">
        		<table>
        			<thead>
        				<tr>
        					<th>报销单号</th>
        					<th>报销单名</th>
        					<th>条目数</th>
        					<th>提交人</th>
        					<th>提交日期</th>
        					<th>金额</th>
        					<th>操作</th>
        				</tr>
        			</thead>
        			<tbody>
        				<tr ng-repeat="item in reportArray">
        					<td>{{item.id}}</td>
        					<td>{{item.title}}</td>
        					<td>{{item.item_count}}</td>
        					<td>{{item.uid}}</td>
        					<td>{{item.submitdt}}</td>
        					<td>￥{{item.amount}}</td>
        					<td><a ng-click="onRemoveItem(item)" href="">删除</a></td>
        				</tr>
        			</tbody>
        		</table>
        		<div>
        			付款说明
        			<textarea name="" id="" cols="30" rows="10"></textarea>
        		</div>
        	</div>
        </div>

        <div class="sub-mod">
        	<div class="head">付款信息</div>
        	<div class="content">
        		<p>已开启用户姓名校验</p>
	        	<div class="one-time-password">动态口令</div>
	        	<div class="field-input">
	        		<input type="text">
	        	</div>
	        	<button>短信获取口令</button>
	        	将向您的手机1112发送动态口令，如果手机有修改或发生异常，请联系客服修改，请在个人信息中，绑定手机号后，使用该功能，或联系云报销客服
        	</div>
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