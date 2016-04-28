<script src="/app/libs/angular/angular.js"></script>
<link rel="stylesheet" href="/static/css/mod/component/fields.css"/>
<link rel="stylesheet" href="/static/css/mod/report/show.css"/>
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
<div class="mod mod-show-report" ng-app="reimApp">
    <div class="page-content-area" ng-controller="ReportController">
        <div class="ui-loading-layer" ng-if="!isLoaded">
            <div class="ui-loading-icon"></div>
        </div>
        <div class="report" data-type="{{template.type.join(',')}}">
            <div class="report-header">
                <img src="/static/img/mod/report/titleBG-Line.png" alt="">
                <span>{{template.name}}</span>
            </div>
            <div class="report-body">
                <div class="block-row report-title">
                    <div class="field-label">报销单名称</div>
                    <div class="field-input" style="line-height: 40px">
                    {{report.title}}
                    </div>
                </div>
                <div class="block-row detail-row" ng-if="path_type!='snapshot' &&report.pa_approval==1 && (report.prove_ahead==1||report.prove_ahead==2)">
                    <div class="field-label" ng-if="report.pa_approval==1 && report.prove_ahead==1">申请额</div>
                    <div class="field-label" ng-if="report.pa_approval==1 && report.prove_ahead==2">已付</div>
                    <div class="field-input">
                        <p>¥{{report.amount}}</p>
                        <a href="/reports/snapshot/{{report.id}}?tid={{template.id}}" class="btn-detail" ng-if="report.has_snapshot && path_type!='snapshot'">
                            <img src="/static/img/mod/report/24/btn-eye@2x.png" alt="">详情
                        </a>
                    </div>
                </div>
                <div class="block-row" ng-if="submitter && path_type!='snapshot'">
                    <div class="field-label">提交人</div>
                    <div class="approvers selected-members">
                        <ul>
                            <li style="width: 100%;">
                                <img ng-src="{{submitter.apath || default_avatar}}" alt="">
                                <div class="info" style="width: auto;">
                                    <div class="name">{{submitter.nickname}}</div>
                                    <div class="role">
                                        <span>{{submitter.d}}</span>
                                        <span>{{submitter.phone}}</span>
                                        <span>{{submitter.email}}</span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="block-row" ng-if="path_type!='snapshot'">
                    <div class="field-label">审批人</div>
                    <div class="approvers selected-members">
                        <ul>
                            <li ng-repeat='m in selectedMembers'>
                                <img ng-src="{{m.apath || default_avatar}}" alt="">
                                <div class="info">
                                    <div class="name">{{m.nickname}}</div>
                                    <div class="role">{{m.d}}</div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="block-row" ng-repeat="tableItem in template.config">
                    <div class="field-label">{{tableItem.name}}</div>
                    <div class="table-field">
                        <div class="table-container">
                            <table>
                                <thead>
                                    <tr>
                                        <th ng-repeat-start="col in tableItem.children" ng-if="col.type==4" colspan="4" >
                                            {{col.name}}
                                        </th>
                                        <th ng-repeat-end ng-if="col.type!=4">{{col.name}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="td-bank" ng-repeat-start="col in tableItem.children" ng-if="col.type==4">
                                            {{col._combine_data_.value['account']}}
                                        </td>
                                        <td class="td-bank" ng-if="col.type==4">
                                            {{col._combine_data_.value['cardno'] || '-'}}
                                        </td>
                                        <td class="td-bank" ng-if="col.type==4">
                                            {{col._combine_data_.value['bankname'] || '-'}}
                                        </td>
                                        <td class="td-bank" ng-if="col.type==4">
                                            {{col._combine_data_.value['subbranch'] || '-'}}
                                        </td>
                                        <td data-id="{{col.id}}" ng-repeat-end ng-if="col.type==3 || col.type==2 || col.type==1">
                                            {{col._combine_data_.value}}
                                        </td>
                                    </tr> 
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="block-row">
                    <div class="field-label">消费明细</div>
                    <div class="table-field">
                        <div class="table-container">
                            <table class="table-consumptions">
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
                                    <tr ng-repeat="c in report.items" ng-class="{selected: c.isSelected}">
                                        <td>{{c['category_name']||'-'}}</td>
                                        <td >{{dateFormat(c.dt)}}</td>
                                        <td>{{c.merchants}}</td>
                                        <td class="note">{{c.notes}}</td>
                                        <td>¥{{c.amount}}</td>
                                    </tr> 
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>合计</td>
                                        <td colspan="4" class="sum">
                                            ¥{{report.amount}}
                                        </td>
                                    </tr>
                                    <tr ng-if="path_type!='snapshot' && report.pa_approval==1 && report.prove_ahead==1">
                                        <td>申请额</td>
                                        <td colspan="4" class="sum">
                                            ¥{{apply_consumption_amount}}
                                        </td>
                                    </tr>
                                    <tr ng-if="path_type!='snapshot' && report.pa_approval==1 && report.prove_ahead==2">
                                        <td>已付</td>
                                        <td colspan="4" class="sum">
                                            ¥{{report.amount}}
                                        </td>
                                    </tr>
                                    <tr ng-if="path_type!='snapshot' && report.pa_approval==1 && report.prove_ahead==2">
                                        <td>应付</td>
                                        <td colspan="4" class="sum">
                                            ¥{{diff_consumption_amount}}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="block-row flow" ng-if="path_type!='snapshot'">
                    <div class="field-label">流转意见</div>
                    <div class="table-field">
                        <div ng-repeat="(gName, fGroup) in flow" ng-if="fGroup.length>0">
                            <h2 ng-class="{first: $first}">{{cutFlowName(gName)}}</h2>
                            <div class="table-container">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>人员</th>
                                            <th>职位</th>
                                            <th>时间</th>
                                            <th>操作</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="f in fGroup">
                                            <td>{{f.nickname}}</td>
                                            <td>{{f.job}}</td>
                                            <td>{{f.udt!=0?f.approvaldt:''}}</td>
                                            <td>{{f.status_text}}</td>
                                        </tr> 
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block-row flow" ng-if="path_type!='snapshot'">
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
            <div class="report-footer" ng-if="path_type!='snapshot'">
                <a href="{{_CONST_REFERER_}}" style="float: left" class="ui-button-border ui-button ui-button-hover btn-back-list">
                    <i class="icon"></i>返回列表
                </a>
                <a ng-if="buttons.has_modify" href="/reports/edit/{{report.id}}?tid={{report.template_id}}" class="ui-button-border ui-button  ui-button-hover btn-modify">
                    <i class="icon"></i>修改
                </a>
                <button ng-if="buttons.has_reject" class="ui-button-border ui-button  ui-button-hover btn-reject" ng-click="onReject(report.id)">
                    <i class="icon"></i>退回
                </button>
                <button ng-if="buttons.has_drop"  class="ui-button-border ui-button  ui-button-hover btn-drop" ng-click="onDrop(report.id)">
                    <i class="icon"></i>撤回
                </button>
                <button ng-if="buttons.has_pass" class="ui-button ui-button-hover btn-pass" ng-click="onPass(report.id)">
                    <i class="icon"></i>通过
                </button>
                <button ng-if="buttons.has_affirm" class="btn-affirm ui-button-hover ui-button" ng-click="onAffirm($event)">
                    <i class="icon"></i>完成确认
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
                        <li class="s_{{s.id}}" ng-repeat='s in suggestionMembers' ng-class="{selected: s.isSelected}"  ng-click="onSelectMember(s)">
                            <img ng-src="{{s.apath || default_avatar }}" alt="">
                            <div class="info">
                                <div class="name">{{s.nickname}}</div>
                                <div class="role">{{s.d}}</div>
                            </div>
                        </li>
                        <li ng-if="suggestionMembers.length>0" class="line"></li>
                        <li class="m_{{m.id}}" ng-repeat='m in (filteredMembers = (members|filter:searchImmediate(txtSearchText)))' ng-class="{selected: m.isSelected}" ng-click="onSelectMember(m)" ng-if="!m._in_sug_">
                            <img ng-src="{{m.apath || default_avatar}}" alt="">
                            <div class="info" ng-bind-html="m.info_html"> </div>
                        </li>
                        <div class="empty-result" ng-if="filteredMembers.length==0">
                            <img src="/static/img/mod/report/icon-no-member-result.png" alt="">
                            <p ng-if="members.length==0">没有可选员工</p>
                            <p ng-if="filteredMembers.length==0">没有搜索结果</p>
                        </div>
                    </ul>
                </div>
            </div>
        </div>  
    </div>
</div>

<script src="/static/js/libs/fecha.js"></script>
<script src="/static/js/libs/underscore-min.js"></script>
<script src="/static/js/jquery.cookie.js"></script>

<script src="/static/js/libs/route-recognizer.js"></script>
<script src="/static/js/shared/services/historyMembers.js"></script>
<script src="/static/js/mod/report/show.js"></script>

<link rel="stylesheet" href="/static/css/base/scrollbar.css">
<script src="/static/plugins/cloud-dialog/dialog.js"></script>
<link rel="stylesheet" href="/static/plugins/cloud-dialog/dialog.css">
