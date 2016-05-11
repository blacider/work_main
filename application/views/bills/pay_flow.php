<!-- basic css resource here -->
<link rel="stylesheet" href="/static/css/widgets/loading-default.css"/>
<link rel="stylesheet" href="/static/css/mod/bills/payflow.css">

<div class="main-content">
	<div class="page-content">
		<div class="page-content-area" ng-app="reimApp">
			<div class="ui-loading-layer" ng-if="isLoaded">
			    <div class="ui-loading-icon">
			    </div>
			</div>
			<div class="mod-pay-flow" ng-controller="PayFlowController">
				<div class="row">
					<div class="col-md-2">付款时间</div>
					<div class="col-md-4">
						<div class="input-group">
					    	<div class="input-group-addon">开始时间</div>
					    	<input type="text" class="form-control btn-start-time" ng-model="startTime" placeholder="开始时间">
					    </div>
					</div>
					<div class="col-md-4">
				    	<div class="input-group">
				        	<div class="input-group-addon">结束时间</div>
				        	<input type="text" class="form-control btn-end-time" ng-model="endTime" placeholder="结束时间">
				        </div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-2">付款状态</div>
					<div class="col-md-8">
						<select class="form-control" ng-model="payStatus">
							<option ng-repeat="statusItem in payStatusArray" value="statusItem.value">{{statusItem.text}}</option>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-md-2">付款金额</div>
					<div class="col-md-6">
						<div class="input-group">
					    	<input type="text" class="form-control min-amount"  ng-model="minAmount" placeholder="最小金额">
					    	<div class="input-group-addon">至</div>
					    	<input type="text" class="form-control max-amount" ng-model="maxAmount" placeholder="最大金额">
					    </div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-2">付款单号</div>
					<div class="col-md-8">
						<input type="text" class="form-control btn-pay-no" ng-model="payNo" placeholder="">
					</div>
				</div>
				<div class="row">
					<div class="col-md-2"></div>
					<div class="col-md-8">
						<button type="button" ng-click="onQuery({startTime: startTime, endTime: endTime, minAmont: minAmont, maxAmount: maxAmount, payNo: payNo, payStatus: payStatus})" class="btn btn-default">查询</button>
					</div>
				</div>

				<div class="content">
				    <div ng-if="payList.length==0">当前报销单已处理完成</div>
				    <div class="table-container" ng-if="payList.length">
				        <table>
				            <thead>
				                <tr>
				                    <th>付款单号</th>
				                    <th>报销单号</th>
				                    <th>报销单名字</th>
				                    <th>付款方式</th>
				                    <th>收款人</th>
				                    <th>付款金额</th>
				                    <th>付款状态</th>
				                    <th>操作</th>
				                </tr>
				            </thead>
				            <tbody>
					            <tr ng-if="payList.length==0">
					            	<td colspan="8">
							            <div>当前报销单已处理完成</div>
					            	</td>
					            </tr>
				                <tr ng-repeat="item in payList">
				                    <td>{{item.local_bill_no}}</td>
				                    <td>{{item.carrier_id}}</td>
				                    <td>{{item.carrier_name}}</td>
				                    <td data-type="{{item.payway}}">微信支付</td>
				                    <td>{{item.employee_name}}</td>
				                    <td>￥{{item.amount}}</td>
				                    <td>{{item.status}}</td>
				                    <td>
				                        <a class="btn-remove" ng-click="onPreviewItem(item)">查看</a>
				                    </td>
				                </tr>
				            </tbody>
				        </table>
				    </div>

				</div>
			</div>
		</div>
	</div>
</div>

<!-- basic js resource here -->
<script src="/app/libs/angular/angular.min.js"></script>
<script src="/static/js/libs/jquery/jquery.min.js"></script>
<script src="/static/js/libs/underscore.js"></script>
<script src="/static/js/libs/utils.js"></script>

<script src="/static/js/mod/bills/payflow.js"></script>

<script src="/static/plugins/cloud-dialog/dialog.js"></script>
<link rel="stylesheet" href="/static/plugins/cloud-dialog/dialog.css">
