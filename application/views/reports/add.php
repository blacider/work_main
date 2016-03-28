<script src="/app/libs/angular/angular.js"></script>
<link rel="stylesheet" href="/static/css/mod/component/fields.css"/>
<link rel="stylesheet" href="/static/css/mod/report/add.css"/>
<link rel="stylesheet" href="/static/css/widgets/loading-default.css"/>
<div class="mod mod-add-report" ng-app="reimApp">
    <div class="page-content-area" ng-controller="ReportController">
        <div class="report">
            <div class="report-header">
                借款单
            </div>
            <div class="report-body">
                <div class="block-row report-title">
                    <div class="field-label">报销单名称</div>
                    <div class="field-input">
                        <input type="text" placeholder="字段组名称" ng-model="tableItem.name" ng-keyup="onTextLengthChange2(tableItem, $event)">
                    </div>
                </div>
                <div class="block-row">
                    <div class="field-label">审批人</div>
                    <a href="javascript:void(0)" class="btn-add-add-approvers ui-button" ng-click="onAddTableConfig(templateItem, $event, $index)"><img src="/static/img/mod/report/36/btn-add-approvers@2x.png" alt="">选择审批人</a>
                </div>
                <div class="block-row">
                    <div class="field-label">借款详情</div>
                    <div class="fields-box">
                        <div class="item">
                            <label for="">借款事由</label>
                            <div class="field-input">
                                <input type="text" placeholder="字段组名称" ng-model="tableItem.name" ng-keyup="onTextLengthChange2(tableItem, $event)">
                            </div>
                        </div>
                        <div class="item">
                            <label for="">借款事由</label>
                            <div class="field-input">
                                <input type="text" placeholder="字段组名称" ng-model="tableItem.name" ng-keyup="onTextLengthChange2(tableItem, $event)">
                            </div>
                        </div>
                        <div class="item">
                            <label for="">借款事由</label>
                            <div class="field-input">
                                <input type="text" placeholder="字段组名称" ng-model="tableItem.name" ng-keyup="onTextLengthChange2(tableItem, $event)">
                            </div>
                        </div>
                        <div class="item">
                            <label for="">借款事由</label>
                            <div class="field-input">
                                <input type="text" placeholder="字段组名称" ng-model="tableItem.name" ng-keyup="onTextLengthChange2(tableItem, $event)">
                            </div>
                        </div>
                        <div class="item">
                            <label for="">借款事由</label>
                            <div class="field-input">
                                <input type="text" placeholder="字段组名称" ng-model="tableItem.name" ng-keyup="onTextLengthChange2(tableItem, $event)">
                            </div>
                        </div>
                        <div class="item">
                            <label for="">借款事由</label>
                            <div class="field-input">
                                <input type="text" placeholder="字段组名称" ng-model="tableItem.name" ng-keyup="onTextLengthChange2(tableItem, $event)">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block-row">
                    <div class="field-label">银行信息详情</div>
                    <div class="fields-box">
                        <div class="item">
                            <label for="">银行信息详情</label>
                            <div class="field-input">
                                <input type="text" placeholder="字段组名称" ng-model="tableItem.name" ng-keyup="onTextLengthChange2(tableItem, $event)">
                            </div>
                        </div>
                        <div class="item">
                            <label for="">银行信息详情</label>
                            <div class="field-input">
                                <input type="text" placeholder="字段组名称" ng-model="tableItem.name" ng-keyup="onTextLengthChange2(tableItem, $event)">
                            </div>
                        </div>
                        <div class="item">
                            <label for="">银行信息详情</label>
                            <div class="field-input">
                                <input type="text" placeholder="字段组名称" ng-model="tableItem.name" ng-keyup="onTextLengthChange2(tableItem, $event)">
                            </div>
                        </div>
                        <div class="item">
                            <label for="">银行信息详情</label>
                            <div class="field-input">
                                <input type="text" placeholder="字段组名称" ng-model="tableItem.name" ng-keyup="onTextLengthChange2(tableItem, $event)">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block-row">
                    <div class="field-label">消费明细</div>
                    <a href="javascript:void(0)" class="btn-add-add-approvers ui-button" ng-click="onAddTableConfig(templateItem, $event, $index)"><img src="/static/img/mod/report/36/consumpution@2x.png" alt="">选择消费</a>
                </div>
            </div>
            <div class="report-footer">
                <a href="javascript:void(0)" style="float: left" class="btn-cancel ui-button" ng-click="onCancelTemplate(templateItem, $event, $index)">
                    <img src="/static/img/mod/report/24/btn-cancel@2x.png" alt="">取消
                </a>
                
                <a href="javascript:void(0)"  class="btn-save ui-button" ng-click="onSaveTemplate(templateItem, $event, $index)"><img src="/static/img/mod/report/24/btn-save@2x.png" alt="">保存</a>

                <a href="javascript:void(0)" class="btn-submit ui-button" ng-click="onPreviewTemplate($event, $index)"><img src="/static/img/mod/report/24/btn-submit@2x.png" alt="">提交</a>

            </div>
            
        </div>  
    </div>
</div>
<script src="/static/js/libs/jquery.auto-grow-input.min.js"></script>
<script src="/static/plugins/cloud-dialog/dialog.js"></script>
<script src="/static/plugins/cloud-dropdown/index.js"></script>
<script src="/static/js/libs/Sortable.min.js"></script>
<script src="/static/js/libs/ng-sortable.js"></script>
<script src="/static/js/mod/report/add.js"></script>
<script src="/static/js/libs/underscore-min.js"></script>

<link rel="stylesheet" href="/static/css/base/animate.css">
<link rel="stylesheet" href="/static/plugins/cloud-dialog/dialog.css">