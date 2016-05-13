<!-- basic css resource here -->
<link rel="stylesheet" href="/static/css/widgets/loading-default.css"/>
<link rel="stylesheet" href="/static/css/mod/component/fields.css"/>
<link rel="stylesheet" href="/static/css/mod/bills/payflow.css">

<div class="main-content">
    <div class="page-content">
        <div class="page-content-area" ng-app="reimApp" ng-controller="PayFlowController">
            <div class="ui-loading-layer" ng-if="!isLoaded">
                <div class="ui-loading-icon">
                </div>
            </div>
            <div class="mod-pay-flow">
                <div class="row">
                    <div class="col-md-2">付款时间</div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <div class="input-group-addon">开始时间</div>
                            <input type="text" class="form-control datepicker start-time" ng-model="startTime" placeholder="开始时间">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <div class="input-group-addon">结束时间</div>
                            <input type="text" class="form-control datepicker end-time" ng-model="endTime" placeholder="结束时间">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">付款状态</div>
                    <div class="col-md-8">
                        <div ng-dropdown="makeStatusDropDown" class="field-select field" default-item="payStatusArray[0]" data="payStatusArray">
                            <i class="icon">
                                <img src="/static/img/mod/template/icon/triangle@2x.png" alt="" />
                            </i>
                            <div class="text font-placeholder"></div>
                            <div class="option-list none">
                                <div class="item" ng-repeat="statusItem in payStatusArray" data-value="{{statusItem.value}}">{{statusItem.text}}</div>
                            </div> 
                        </div>
                        <!-- <select class="form-control pay-status">
                            <option ng-repeat="statusItem in payStatusArray" selected="{{statusItem.value===''}}" value="{{statusItem.value}}">{{statusItem.text}}</option>
                        </select> -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">付款金额</div>
                    <div class="col-md-8">
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
                        <input type="text" class="form-control pay-no" ng-model="payNo" placeholder="">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <button type="button" ng-click="onQuery({startTime: startTime, endTime: endTime, minAmont: minAmont, maxAmount: maxAmount, payNo: payNo, payStatus: payStatus})" class="btn-query">查询</button>
                    </div>
                </div>
                <div class="content">
                    <div ng-if="payList.length==0" style="padding: 20px; text-align: center;">暂无结果</div>
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
                                    <td class="pay-no">{{item.local_bill_no}}</td>
                                    <td>{{item.carrier_id}}</td>
                                    <td>{{item.carrier_name}}</td>
                                    <td data-type="{{item.payway}}">微信支付</td>
                                    <td>{{item.employee_name}}</td>
                                    <td>￥{{item.amount}}</td>
                                    <td><span>{{item.status}}</span></td>
                                    <td>
                                        <a class="btn-remove" ng-click="onPreviewItem(item)">查看</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div style="text-align: center;">
                        <ul ng-if="pageNaviData.totalPage>1" class="pagination">
                            <li ng-if="pageNaviData.current+1!=1"><a ng-click="onPage(pageNaviData.start-1, pageNaviData)">首页</a></li>
                            <li ng-if="pageNaviData.prev"><a ng-click="onPage(pageNaviData.prev, pageNaviData)"><</a></li>
                            <li ng-class="{active: a-1==pageNaviData.current}" ng-repeat="a in pageNaviData.list"><a ng-click="onPage(a-1, pageNaviData)">{{a}}</a></li>
                            <li ng-if="pageNaviData.next"><a ng-click="onPage(pageNaviData.next, pageNaviData)">></a></li>
                            <li ng-if="pageNaviData.totalPage!=pageNaviData.current+1"><a ng-click="onPage(pageNaviData.end, pageNaviData)">尾页</a></li>
                            <li><a>共{{pageNaviData.totalPage}}页</a></li>
                        </ul>
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

<script src="/static/plugins/cloud-dropdown/index.js"></script>

<!-- datatimerpicker  -->
<script src="/static/plugins/bootstrap-datepicker/js/bootstrap-datetimepicker.js"></script>
<script src="/static/plugins/bootstrap-datepicker/js/locales/bootstrap-datetimepicker.zh-CN.js"></script>

<script src="/static/js/mod/bills/payflow.js"></script>

<script src="/static/plugins/cloud-dialog/dialog.js"></script>
<link rel="stylesheet" href="/static/plugins/cloud-dialog/dialog.css">

