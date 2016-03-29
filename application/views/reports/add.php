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
                        <input type="text" placeholder="报销单" ng-model="report.title">
                    </div>
                </div>
                <div class="block-row">
                    <div class="field-label">审批人</div>
                    <div class="approvers selected-members">
                        <ul>
                            <li ng-repeat='m in selectedMembers'>
                                <img src="{{m.apath || '/static/img/mod/report/default-avatar.png'}}" alt="">
                                <div class="info">
                                    <p class="name">{{m.nickname}}</p>
                                    <p class="role">{{formatMember(m)}}</p>
                                </div>
                            </li>
                            <li class="btn-append">
                                <a href="javascript:void(0)" class="btn-add-add-approvers ui-button" ng-click="onAddApprovers($event)"><img src="/static/img/mod/report/36/btn-add-approvers@2x.png" alt="">选择</a>
                            </li>
                        </ul>
                    </div>
                    
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
                    <a href="javascript:void(0)" class="btn-add-add-approvers ui-button" ng-click="onAddConsumptions($event)"><img src="/static/img/mod/report/36/consumpution@2x.png" alt="">选择消费</a>
                </div>
            </div>
            <div class="report-footer">
                <a href="javascript:void(0)" style="float: left" class="btn-cancel ui-button" ng-click="onCancel($event)">
                    <img src="/static/img/mod/report/24/btn-cancel@2x.png" alt="">取消
                </a>
                
                <a href="javascript:void(0)"  class="btn-save ui-button" ng-click="onSave($event)"><img src="/static/img/mod/report/24/btn-save@2x.png" alt="">保存</a>

                <a href="javascript:void(0)" class="btn-submit ui-button" ng-click="onSubmit($event)"><img src="/static/img/mod/report/24/btn-submit@2x.png" alt="">提交</a>

            </div>
            <!-- 接口太慢，预先加载公司成员，隐藏于此 -->
            <div style="display: none">
                <div class="approvers available-members">
                    <div class="search-input">
                        <div class="field-input">
                            <input type="text" placeholder="姓名／手机／邮箱" ng-model="search.$" >
                        </div>
                        <a href="javascript:void(0)" class="btn-search ui-button" ng-click="">搜索</a>
                    </div>
                    <ul>
                        <li ng-repeat='m in members|filter:search' ng-init="m['show_info'] = formatMember(m)" ng-class="{selected: m.isSelected}" ng-click="onSelectMember(m, $event)">
                            <img src="{{m.apath || '/static/img/mod/report/default-avatar.png'}}" alt="">
                            <div class="info">
                                <p class="name">{{m.nickname}}</p>
                                <p class="role">{{formatMember(m)}}</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- 接口太慢，预先加载消费，隐藏于此 -->
            <!-- <div style="display: none;"> -->
            <div style="display: block;">
                <div class="consumptions available-consumptions">
                    <table class="border-radius-row">
                        <thead>
                            <tr>
                                <td>类目</td>
                                <td>时间</td>
                                <td>商家</td>
                                <td>备注</td>
                                <td>金额</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="c in consumptions" ng-class="{selected: c.isSelected}" ng-click="onSelectConsumption(c, $event)">
                                <td>{{c.category}}</td>
                                <td >{{c.dt}}</td>
                                <td>{{c.merchants}}</td>
                                <td>{{c.notes}}</td>
                                <td>{{c.amount}}</td>
                            </tr> 
                        </tbody>
                    </table>
            </div>
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
<link rel="stylesheet" href="/static/css/base/scrollbar.css">