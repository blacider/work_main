<script src="/app/libs/angular/angular.js"></script>
<link rel="stylesheet" href="/static/css/mod/component/fields.css"/>
<link rel="stylesheet" href="/static/css/mod/report/add.css"/>
<link rel="stylesheet" href="/static/css/widgets/loading-default.css"/>
<div class="mod mod-add-report" ng-app="reimApp">
    <div class="page-content-area" ng-controller="ReportController">
        <div class="report" data-id="<?php echo $template_id;?>">
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

                <div class="block-row" ng-repeat="tableItem in report.config">
                    <div class="field-label">{{tableItem.name}}</div>
                    <div class="fields-box">
                        <div  class="field-item" ng-repeat="fieldItem in tableItem.children" ng-if="fieldItem.type==1">
                            <label for="">{{fieldItem.name}}</label>
                            <div class="field-input">
                                <input type="text" placeholder=""  ng-keyup="onTextLengthChange2(tableItem, $event)">
                            </div>
                        </div>
                        <div  class="field-item" ng-repeat="fieldItem in tableItem.children" ng-if="fieldItem.type==2">
                            <label for="">{{fieldItem.name}}</label>
                            <div class="field-select field" ng-dropdown="makeRadioDropdown" data="fieldItem.property.options">
                                <i class="icon">
                                    <img src="/static/img/mod/template/icon/triangle@2x.png" alt="" />
                                </i>
                                <div class="text font-placeholder">请选择选项</div>
                                <div class="option-list none">
                                    <div class="item" ng-repeat="item in fieldItem.property.options" data-value="{{item}}">{{item}}</div>
                                </div> 
                            </div>
                        </div>
                        <div  class="field-item" ng-repeat="fieldItem in tableItem.children" ng-if="fieldItem.type==3">
                            <label for="">{{fieldItem.name}}日期类型</label>
                            <div class="field-input datatimepicker">
                                <i class="icon">
                                    <img src="/static/img/mod/report/36/icon-calender@2x.png" alt="" />
                                </i>
                                <input type="text" placeholder=""  ng-keyup="onTextLengthChange2(tableItem, $event)">
                            </div>
                        </div>
                        <div  class="field-item" ng-repeat="fieldItem in tableItem.children" ng-if="fieldItem.type==4">
                            <label for="">{{fieldItem.name}}</label>
                            <div class="field-select field" ng-dropdown="makeBankDropdown" selected-item="default_bank"  default-item="{value:'', text: '请选择银行'}"  data="banks">
                                <i class="icon">
                                    <img src="/static/img/mod/template/icon/triangle@2x.png" alt="" />
                                </i>
                                <div class="text font-placeholder">请选择银行</div>
                                <div class="option-list none">
                                    <div class="item" ng-repeat="item in banks" data-value="{{item.id}}">{{makeBankDropdown.itemFormat(item)['text']}}</div>
                                </div> 
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




<script src="/static/ace/js/date-time/moment.js"></script>
<script src="/static/ace/js/date-time/locale/zh-cn.js"></script>
<script src="/static/ace/js/date-time/bootstrap-datetimepicker.min.js"></script>

<script src="/static/js/libs/jquery.auto-grow-input.min.js"></script>
<script src="/static/plugins/cloud-dialog/dialog.js"></script>
<script src="/static/plugins/cloud-dropdown/index.js"></script>
<script src="/static/js/libs/Sortable.min.js"></script>
<script src="/static/js/libs/ng-sortable.js"></script>
<script src="/static/js/libs/underscore-min.js"></script>


<script src="/static/js/mod/report/add.js"></script>

<link rel="stylesheet" href="/static/css/base/animate.css">
<link rel="stylesheet" href="/static/plugins/cloud-dialog/dialog.css">
<link rel="stylesheet" href="/static/ace/css/bootstrap-datetimepicker.css" />