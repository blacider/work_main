<!-- basic css resource here -->
<link rel="stylesheet" href="/static/css/mod/bills/payflow.css">

<div class="main-content">
	<div class="page-content">
		<div class="page-content-area" ng-app="reimApp">
			<div class="mod-pay-flow" ng-controller="PayFlowController">
				<div class="row">
					<div class="col-md-2">付款时间</div>
					<div class="col-md-4">
						<div class="input-group">
					    	<div class="input-group-addon">开始时间</div>
					    	<input type="text" class="form-control">
					    </div>
					</div>
					<div class="col-md-4">
				    	<div class="input-group">
				        	<div class="input-group-addon">结束时间</div>
				        	<input type="text" class="form-control">
				        </div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-2">付款状态</div>
					<div class="col-md-8">
						<select class="form-control">
							<option>1</option>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-md-2">付款金额</div>
					<div class="col-md-6">
						<div class="input-group">
					    	<input type="text" class="form-control" placeholder="最小金额">
					    	<div class="input-group-addon">至</div>
					    	<input type="text" class="form-control" placeholder="最大金额">
					    </div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-2">付款单号</div>
					<div class="col-md-8">
						<input type="text" class="form-control" placeholder="">
					</div>
				</div>
				<div class="row">
					<div class="col-md-2"></div>
					<div class="col-md-8">
						<button type="button" class="btn btn-default">查询</button>
					</div>
				</div>

				<div class="content">
				    <div ng-if="payList.length==0">当前报销单已处理完成</div>
				    <div class="table-container" ng-if="payList.length">
				        <table>
				            <thead>
				                <tr>
				                    <th>付款单号</th>
				                    <th>报销单名字</th>
				                    <th>付款方式</th>
				                    <th>报销单号</th>
				                    <th>收款人</th>
				                    <th>付款金额</th>
				                    <th>付款状态</th>
				                    <th>操作</th>
				                </tr>
				            </thead>
				            <tbody>
				                <tr ng-repeat="item in payList">
				                    <td>{{item.local_bill_no}}</td>
				                    <td>{{item.carrier_id}}</td>
				                    <td>{{item.payway}}</td>
				                    <td>{{item.carrier_id}}</td>
				                    <td>{{item.uid}}</td>
				                    <td>￥{{item.amount}}</td>
				                    <td>{{item.status}}</td>
				                    <td>
				                        <a class="btn-remove" ng-href="/pay/detail/{{item.id}}">查看</a>
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
