<script src="/app/libs/angular/angular.js"></script>
<link rel="stylesheet" href="/static/css/mod/component/fields.css"/>
<link rel="stylesheet" href="/static/css/mod/report/add.css"/>
<link rel="stylesheet" href="/static/css/widgets/loading-default.css"/>
<script>
(function () {
    var error = '';
    <?php if(isset($last_error)) { ?>
        error = "<?php echo $last_error;?>";
    <?php } ?>
    if(error) {
        show_notify(error);
    }
})();
</script>
<div class="mod mod-add-report" ng-app="reimApp">
    <div class="page-content-area" ng-controller="ReportController">
        <div class="ui-loading-layer" ng-if="!isLoaded">
            <div class="ui-loading-icon"></div>
        </div>
        <div class="report" data-tid="<?php echo $template_id; ?>" data-type="{{template.type.join(',')}}">
            <div class="report-header">
                <img src="/static/img/mod/report/titleBG-Line.png" alt="">
                <span>{{template.name}}</span>
            </div>
            <div class="report-body">
                <div class="block-row report-title">
                    <div class="field-label">报销单名称</div>
                    <div class="field-input">
                        <input type="text" ng-model="title">
                    </div>
                </div>
                <div class="block-row detail-row" ng-if="__edit__ && report.pa_approval==1 && (report.prove_ahead==1||report.prove_ahead==2)">
                    <div class="field-label" ng-if="report.pa_approval==1 && report.prove_ahead==1">申请额</div>
                    <div class="field-label" ng-if="report.pa_approval==1 && report.prove_ahead==2">已付</div>
                    <div class="field-input">
                        <p>¥{{_first_turn_amount_}}</p>
                        <a href="/reports/snapshot/{{report.id}}?tid={{template.id}}" class="btn-detail" ng-if="report.has_snapshot && path_type!='snapshot'">
                            <img src="/static/img/mod/report/24/btn-eye@2x.png" alt="">详情
                        </a>
                    </div>
                </div>
                <div class="block-row">
                    <div class="field-label">审批人</div>
                    <div class="approvers selected-members">
                        <ul>
                            <li ng-repeat='m in selectedMembers track by $index'>
                                <img ng-src="{{m.apath || default_avatar}}" alt="">
                                <div class="info">
                                    <div class="name">{{m.nickname}}</div>
                                    <div class="role">{{m.d}}</div>
                                </div>
                                <p ng-if="!_disable_modify_approver_" class="btn-remove" ng-click="onRemoveApprover(m)"></p>
                            </li>
                            <li class="btn-append" ng-if="!_disable_modify_approver_">
                                <button class="button-gray ui-button" ng-click="onAddApprovers($event)"><img src="/static/img/mod/report/36/btn-add-approvers@2x.png" alt="">选择审批人</button>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- 1.是自己，就展示抄送，2.是审批人，抄送列表为空不展示 -->
                <div class="block-row" ng-if="hasCC && !is_approver || hasCC && is_approver && selectedMembersCC.length>0">
                    <div class="field-label">抄送至</div>
                    <div class="approvers selected-members">
                        <ul>
                            <li ng-repeat='m in selectedMembersCC track by $index'>
                                <img ng-src="{{m.apath || default_avatar}}" alt="">
                                <div class="info">
                                    <div class="name">{{m.nickname}}</div>
                                    <div class="role">{{m.d}}</div>
                                </div>
                                <p class="btn-remove" ng-click="onRemoveApprover(m, 'cc')" ng-if="!_disable_modify_approver_"></p>
                            </li>
                            <li class="btn-append" ng-if="!_disable_modify_approver_">
                                <button class="button-gray ui-button" ng-click="onAddApprovers($event, 'cc')"><img src="/static/img/mod/report/36/btn-add-approvers@2x.png" alt="">选择抄送人</button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="block-row field-item-list" ng-repeat="tableItem in template.config">
                    <div class="field-label">{{tableItem.name}}</div>
                    <div class="fields-box">
                        <div class="field-item" data-required="{{fieldItem.required==1}}" data-type="{{fieldItem.type}}" data-id="{{fieldItem.id}}" ng-repeat-start="fieldItem in tableItem.children" ng-if="fieldItem.type==1">
                            <label for="">{{fieldItem.name}}</label>
                            <div class="field-input">
                                <input type="text" placeholder="{{fieldItem.required==1?'必填':'选填'}}">
                            </div>
                        </div>
                        <div  class="field-item" data-required="{{fieldItem.required==1}}" ng-init="fieldItem._options_=formatOptions(fieldItem)" data-type="{{fieldItem.type}}" data-id="{{fieldItem.id}}" ng-if="fieldItem.type==2">
                            <label for="">{{fieldItem.name}}</label>
                            <div class="field-select field" ng-dropdown="makeRadioDropDown" default-item="{text: fieldItem.required==1?'必填':'选填'}" can-deselect="1" data="fieldItem._options_">
                                <i class="icon">
                                    <img src="/static/img/mod/template/icon/triangle@2x.png" alt="" />
                                </i>
                                <div class="text font-placeholder"></div>
                                <div class="option-list none">
                                    <div class="item" ng-repeat="item in fieldItem._options_" data-value="{{item}}">{{makeRadioDropDown.itemFormat(item)['text']}}</div>
                                </div> 
                            </div>
                        </div>
                        <div  class="field-item" data-required="{{fieldItem.required==1}}" data-type="{{fieldItem.type}}" data-id="{{fieldItem.id}}" ng-if="fieldItem.type==3">
                            <label for="">{{fieldItem.name}}</label>
                            <div class="field-input datatimepicker">
                                <i class="icon">
                                    <img src="/static/img/mod/report/36/icon-calender@2x.png" alt="" />
                                </i>
                                <input type="text" placeholder="{{fieldItem.required==1?'必填':'选填'}}">
                            </div>
                        </div>
                         <!-- 非必填，下拉可反选！ -->
                        <div  class="field-item" data-required="{{fieldItem.required==1}}" data-type="{{fieldItem.type}}" data-id="{{fieldItem.id}}" ng-repeat-end ng-if="fieldItem.type==4">
                            <label for="">{{fieldItem.name}}</label>
                            <div class="field-select field" ng-dropdown="makeBankDropdown" can-deselect="1" selected-item="default_bank" default-item="{text: fieldItem.required==1?'必填':'选填'}" data="banks">
                                <i class="icon">
                                    <img src="/static/img/mod/template/icon/triangle@2x.png" alt="" />
                                </i>
                                <div class="text font-placeholder"></div>
                                <div class="option-list none option-list-extra">
                                    
                                    <div class="option-list-wrap">
                                        <div class="item" ng-repeat="item in banks" data-value="{{item.id}}">{{makeBankDropdown.itemFormat(item)['text']}}</div>
                                    </div>
                                    <p class="line" ng-if="banks.length<=1"><span>0张银行卡</span></p>
                                    <button class="btn-add-bank ui-button-hover" ng-click="onAddBankCard($event)">
                                        <img src="/static/img/mod/report/36/icon-bank@2x.png" alt="" />
                                        添加银行卡
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block-row" ng-if="selectedConsumptions && selectedConsumptions.length>0">
                    <div class="field-label">消费明细</div>
                    <div class="table-field">
                        <div style="text-align: right; padding-bottom: 20px;">
                            <button class="btn-edit-consumption" ng-click="onAddConsumptions($event)">
                            <i class="icon"></i>
                            编辑</button>
                        </div>
                        <div class="table-container">
                            <table>
                                <thead>
                                    <tr>
                                        <th>类目</th>
                                        <th>时间</th>
                                        <th>商家 </th>
                                        <th>备注</th>
                                        <th>金额</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="c in selectedConsumptions" ng-class="{selected: c.isSelected}" ng-click="onSelectConsumption(c, $event)">
                                        <td>{{c['category_name']||'-'}}</td>
                                        <td >{{dateFormat(c.dt)||'-'}}</td>
                                        <td>{{c.merchants||'-'}}</td>
                                        <td class="note">{{c.note||'-'}}</td>
                                        <td>{{exchangeRateMap[c.currency]}}{{c.amount}} </td>
                                    </tr> 
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>合计</td>
                                        <td colspan="4" class="sum">
                                            ¥{{getItemsAmount(selectedConsumptions)}}
                                        </td>
                                    </tr>
                                    <tr ng-if="report.pa_approval==1 && report.prove_ahead==1">
                                        <td>申请额</td>
                                        <td colspan="4" class="sum">
                                            ¥{{_first_turn_amount_}}
                                        </td>
                                    </tr>
                                    <tr ng-if="report.pa_approval==1 && report.prove_ahead==2">
                                        <td>已付</td>
                                        <td colspan="4" class="sum">
                                            ¥{{_first_turn_amount_}}
                                        </td>
                                    </tr>
                                    <tr ng-if="report.pa_approval==1 && report.prove_ahead==2">
                                        <td>应付</td>
                                        <td colspan="4" class="sum">
                                            ¥{{(getItemsAmount(selectedConsumptions) - _first_turn_amount_).toFixed(2)}}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="block-row" ng-if="!selectedConsumptions || selectedConsumptions.length==0">
                    <div class="field-label">消费明细</div>
                    <button class="button-gray ui-button btn-add-consumptions" ng-click="onAddConsumptions($event)"><img style="margin-right: -2px" src="/static/img/mod/report/36/consumpution@2x.png" alt="">选择消费</button>
                </div>
                <div class="block-row flow" ng-if="__edit__">
                    <div class="field-label">留言</div>
                    <div class="field-input">
                        <div class="msg-item" ng-repeat="commentItem in commentArray">
                            <img ng-src="{{commentItem.user['apath'] || default_avatar}}" alt="">
                            <div class="content">
                                <div class="title">
                                    <div class="name">{{commentItem.nickname}}</div>
                                    <div class="date-time">{{dateFormat(commentItem.lastdt)}}</div>
                                </div>
                                <div class="text">
                                    {{commentItem.comment}}
                                </div>
                            </div>
                        </div>
                        <div class="msg-input">
                            <div class="field-input">
                                <input type="text" placeholder="" ng-model="comment_box.txtCommentMessage">
                            </div>
                            <button class="btn-search ui-button" ng-click="onAddCommentToReport()">提交留言</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="report-footer">
                <button style="float: left" class="btn-cancel ui-button ui-button-hover" ng-click="onCancel($event)">
                    <i class="icon"></i>取消
                </button>
                
                <button  class="btn-save ui-button ui-button-hover" ng-click="onSave($event)">
                    <i class="icon"></i>保存
                </button>

                <button ng-if="!is_approver" class="btn-submit ui-button ui-button-hover" ng-click="onSubmit($event)">
                    <i class="icon"></i>提交
                </button>

            </div>
            <!-- 接口太慢，预先加载公司成员，隐藏于此 -->
            <div style="display: none">
                <div class="approvers available-members">
                    <div class="search-input">
                        <div class="field-input">
                            <i class="icon left">
                                <img src="/static/img/mod/report/24/icon-search@2x.png" alt="">
                            </i>
                            <input type="text" placeholder="姓名／手机／邮箱" ng-model="txtSearchText">
                        </div>
                    </div>
                    <ul>
                        <li class="s_{{s.id}}" ng-repeat='s in (filteredSugMembers = (suggestionMembers|filter:searchImmediate(txtSearchText)))' ng-class="{selected: s.isSelected}"  ng-click="onSelectMember(s)" ng-dblclick="onRemoveHistory(s)">
                            <img ng-src="{{s.apath || default_avatar }}" alt="">
                            <div class="info">
                                <div class="name">{{s.nickname}}</div>
                                <div class="role">{{s.d}}</div>
                            </div>
                        </li>
                        <li ng-if="filteredSugMembers.length>0" class="line"></li>
                        <li ng-if="!m._IN_SUG_" class="m_{{m.id}}" ng-repeat='m in (filteredMembers = (members|filter:searchImmediate(txtSearchText)))' ng-class="{selected: m.isSelected}" ng-click="onSelectMember(m, $event)">
                            <img ng-src="{{m.apath || default_avatar}}" alt="">
                            <div class="info" ng-bind-html="m.info_html"> </div>
                        </li>
                        <div class="empty-result" ng-if="filteredMembers.length==0">
                            <img src="/static/img/mod/report/icon-no-member-result.png" alt="" ng-if="members.length==0">
                            <img src="/static/img/mod/report/icon-no-member-result-search.png" alt="" ng-if="members.length !=0 && filteredMembers.length==0">
                            <p ng-if="members.length==0">没有可选员工</p>
                            <p ng-if="members.length !=0 && filteredMembers.length==0">没有搜索结果</p>
                        </div>
                    </ul>
                </div>
            </div>

            <!-- 接口太慢，预先加载消费，隐藏于此 -->
            <!-- /*<div style="display: none;">*/ -->
            <div style="display: none;">
                <div class="consumptions available-consumptions">
                    <div class="head" ng-if="filteredConsumptions.length!=0" style="visibility: {{is_approver? 'hidden': ''}};">
                        <a class="btn-select" ng-click="onSelectAllConsumptions($event)" ng-if="has_select_consumption">
                            <i class="icon"></i>
                            全选
                        </a>
                        <a class="btn-select btn-deselect" ng-click="onDeselectAllConsumptions($event)" ng-if="has_deselect_consumption">
                            <i class="icon"></i>
                            取消选中
                        </a>
                    </div>
                    <div class="moni-table">
                        <div class="t-head" ng-if="availableConsumptions.length!=0">
                            <div class="t-row">
                                <div class="col">类目</div>
                                <div class="col dt">日期</div>
                                <div class="col">商家</div>
                                <div class="col">备注</div>
                                <div class="col">金额</div>
                            </div>
                        </div>
                        <div class="t-body">
                            <div class="t-row c_{{c.id}}_rid{{c.rid}}" ng-if="c.rid==0 || c.rid == __report_id__" ng-repeat="c in consumptions" ng-class="{selected: c.isSelected}"   ng-click="onSelectConsumption(c, $event)">
                                <div class="col">{{c['category_name']||'-'}}</div>
                                <div class="col dt">{{dateFormat(c.dt)||'-'}}</div>
                                <div class="col">{{c.merchants||'-'}}</div>
                                <div class="col note">{{c.note||'-'}}</div>
                                <div class="col">{{exchangeRateMap[c.currency]}}{{c.amount}}</div>
                                <div class="col btn-edit">
                                    <a class="icon" href="/items/edit/{{c.id}}">
                                    </a>
                                </div>
                            </div>
                            <div class="empty-result" ng-if="availableConsumptions.length==0">
                                <img src="/static/img/mod/report/icon-no-member-result.png" alt="">
                                <p>当前没有可选择的消费</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div style="display: none">
                <div class="bank-form">
                    <div  class="field-item">
                        <label for="">持卡人</label>
                        <div class="field-input account">
                            <input name="account" type="text" placeholder="">
                        </div>
                    </div>
                    <div  class="field-item">
                        <label for="">帐号</label>
                        <div class="field-input card-number" ng-keyup="onBankNumberChange($event)">
                            <input name="account" type="text" placeholder="" ng-model="formBankNumber">
                        </div>
                    </div>
                    <div  class="field-item">
                        <label for="">开户行</label>
                        <div class="field-select field bank-db-list" ng-dropdown="makeDropDownBankDB" data="[]">
                            <i class="icon">
                                <img src="/static/img/mod/template/icon/triangle@2x.png" alt="" />
                            </i>
                            <div class="text font-placeholder"></div>
                            <div class="option-list none">
                                <div class="input-search-helper">
                                    <input type="text" ng-model="txtBankInput" ng-keyup="onSearchEnd($event)">
                                </div>
                                <div class="option-list-wrap" style="width: auto;">
                                    <div class="item" ng-repeat="name in (filteredBANK_DB=(BANK_DB_ARRAY|filter:txtBankInput))" data-value="{{name}}">{{name}}</div>
                                </div>
                            </div> 
                        </div>
                    </div>
                    <div  class="field-item">
                        <label for="">卡类型</label>
                        <div class="field-select field card-type" ng-dropdown="makeDropDownBankTypes" data="bankCardTypes">
                            <i class="icon">
                                <img src="/static/img/mod/template/icon/triangle@2x.png" alt="" />
                            </i>
                            <div class="text font-placeholder"></div>
                            <div class="option-list none">
                                <div class="item" ng-repeat="item in bankCardTypes" data-value="{{item.value}}">{{item.text}}</div>
                            </div> 
                        </div>
                    </div>
                    <div class="field-item-wrap">
                        <div  class="field-item inline-item">
                            <label for="">开户地</label>
                            <div class="field-select field province" ng-dropdown="makeDropDownProvince" data="[]">
                                <i class="icon">
                                    <img src="/static/img/mod/template/icon/triangle@2x.png" alt="" />
                                </i>
                                <div class="text font-placeholder"></div>
                                <div class="option-list none">
                                    <div class="item" ng-repeat="item in __PROVINCE_WITH_CITIES__" data-value="{{item.name}}">{{item.name}}</div>
                                </div> 
                            </div>
                        </div>
                        <div  class="field-item inline-item" style="padding-right: 0;padding-left: 5px;">
                            <label for="" style="height: 20px"></label>
                            <div class="field-select field city" ng-dropdown="makeDropDownCity" data="[]">
                                <i class="icon">
                                    <img src="/static/img/mod/template/icon/triangle@2x.png" alt="" />
                                </i>
                                <div class="text font-placeholder"></div>
                                <div class="option-list none">
                                    <div class="item" ng-repeat="item in __CITIES__" data-value="{{item}}">{{item}}</div>
                                </div> 
                            </div>
                        </div>
                    </div>
                    <div  class="field-item">
                        <label for="">开户支行</label>
                        <div class="field-input subbranch">
                            <input type="text">
                        </div>
                    </div>
                    <div style="clear: both"></div>
                </div>
            </div>
        </div>  
    </div>
</div>

<script src="/static/plugins/bootstrap-datepicker/js/bootstrap-datetimepicker.js"></script>
<script src="/static/plugins/bootstrap-datepicker/js/locales/bootstrap-datetimepicker.zh-CN.js"></script>
<script src="/static/js/libs/fecha.js"></script>
<script src="/static/plugins/cloud-dialog/dialog.js"></script>
<script src="/static/plugins/cloud-dropdown/index.js"></script>
<script src="/static/js/libs/underscore-min.js"></script>
<script src="/static/js/libs/route-recognizer.js"></script>
<script src="/static/js/jquery.cookie.js"></script>
<script src="/static/js/shared/services/historyMembers.js"></script>
<script src="/static/js/shared/services/exchangeRate.js"></script>
<script src="<?= static_url("/static/js/mod/report/add.js") ?>"></script>

<link rel="stylesheet" href="/static/css/base/animate.css">
<link rel="stylesheet" href="/static/plugins/cloud-dialog/dialog.css">
<link rel="stylesheet" href="/static/css/base/scrollbar.css">
<link rel="stylesheet" href="/static/plugins/bootstrap-datepicker/css/bootstrap-datetimepicker.css">
