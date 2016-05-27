<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>云报销企业微信钱包转账</title>
    <!-- 数字证书 -->
    <script>
        window.__CBX_UTOKEN__ = "<?php echo $CBX_UTOKEN['0']; ?>".replace('X-REIM-JWT: ', '');
        var _CONST_API_DOMAIN_ = "<?php echo $api_url_base; ?>";
        window.__UID__ = "<?php echo $UID; ?>";
        window.__USER_ACCESS_TOKEN__ = "<?= $user_access_token ?>";
        window.__CLIEN_ID__ = "<?= $client_id ?>";
        window.__CLIEN_SECRET__ = "<?= $client_secret ?>";
    </script>

    <!-- basic css resource here -->
    <link rel="stylesheet" href="/static/css/widgets/loading-default.css"/>
    <link rel="stylesheet" href="/static/css/mod/bills/paylist.css">


</head>
<body ng-app="reimApp">
    <div class="mod mod-reim-paylist" ng-controller="PayListController">
        <div class="ui-loading-layer" ng-if="!isLoaded" style="position:  fixed;">
            <div class="ui-loading-icon">
            </div>
        </div>
        <div class="company sub-mod">
            <div class="head">企业信息</div>
            <div class="content">
                <div class="name"><label for="">企业名称：</label>{{profile.group['group_name']}}</div>
            </div>
        </div>

        <div class="sub-mod">
            <div class="head">转账报销单</div>
            <div class="content">
                <div ng-if="reportArray.length==0">当前无处理的报销单</div>
                <div class="table-container" ng-if="reportArray.length">
                    <table>
                        <thead>
                            <tr>
                                <th>报销单ID</th>
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
                                <td>{{item.nickname}}</td>
                                <td>{{item.createdt +'000'|date:'yyyy-M-d'}}</td>
                                <td>￥{{moneyFormat(item.amount)}}</td>
                                <td>
                                    <a href="javascript:void(0)" class="btn-remove" ng-click="onRemoveItem(item)">移除</a>
                                </td>
                            </tr>
                        </tbody>

                    </table>
                </div>
                <div style="text-align: right" ng-if="reportArray.length">总额：￥{{getReportArrayAmount(reportArray)}}</div>
                <div class="description" ng-init="forTextAreaId = 'textareaDesc'" ng-if="reportArray.length">
                    <label for="{{textareaDesc}}">付款说明</label>
                    <textarea name="" ng-model="desc" id="{{textareaDesc}}" cols="30" rows="10"></textarea>
                </div>
            </div>
        </div>

        <div class="sub-mod" ng-if="reportArray.length">
            <div class="head">付款信息</div>
            <div class="content">
                <p>已开启用户姓名校验</p>
                <div class="row" style="display: table">
                    <label for="" class="table-cell" style="padding-right: 16px;"><span style="color: #ff575b">*</span>动态口令</label>
                    <div class="field-input table-cell">
                        <input class="btn-vcode" placeholder="请输入验证码" type="text" ng-model="vcode">
                    </div>
                    <button class="btn-send-code table-cell" ng-class="{'waiting': isWaiting}" ng-click="onSendCode()">短信获取口令
                    </button>
                </div>
                <p>
                    将向您的手机<span style="color: #ff575b">{{phoneStars(phone)}}</span>发送动态口令，如果手机有修改或发生异常，请联系客服修改
                </p>
            </div>
            <div class="footer">
                <button class="btn-submit" ng-click="onSubmit(vcode, desc)">提交</button>
            </div>
        </div>
        <!-- loading -->
        <div class="cloud-bx-waiting" ng-if="isSubmitWaiting">
            <div class="text">
            <img class="animated pulse infinite" src="/static/img/loading.png" alt="">
                提交中......
            </div>
        </div>
    </div>

    <!-- basic js resource here -->
    <script src="/app/libs/angular/angular.min.js"></script>
    <script src="/static/js/libs/jquery/jquery.min.js"></script>
    <script src="/static/js/libs/underscore.js"></script>
    <script src="/static/js/libs/utils.js"></script>
    <script src="<?= static_url("/static/js/mod/bills/paylist.js") ?>"></script>

    <script src="/static/plugins/cloud-dialog/dialog.js"></script>
    <link rel="stylesheet" href="/static/plugins/cloud-dialog/dialog.css">

    <script src="/static/plugins/cloud-layer/layer.js"></script>
    <link rel="stylesheet" href="/static/plugins/cloud-layer/layer.css">
    
    <link rel="stylesheet" href="/static/css/base/animate.css">
</body>
</html>