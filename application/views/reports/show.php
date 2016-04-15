<script src="/app/libs/angular/angular.js"></script>
<link rel="stylesheet" href="/static/css/mod/component/fields.css"/>
<link rel="stylesheet" href="/static/css/mod/report/show.css"/>
<link rel="stylesheet" href="/static/css/widgets/loading-default.css"/>
<div class="mod mod-show-report" ng-app="reimApp">
    <div class="page-content-area" ng-controller="ReportController">
        <div class="ui-loading-layer" ng-if="!isLoaded">
            <div class="ui-loading-icon"></div>
        </div>
        <div class="report" data-type="{{template.type.join(',')}}">
            <div class="report-header">
                {{template.name}}
            </div>
            <div class="report-body">
                <div class="block-row report-title">
                    <div class="field-label">报销单名称</div>
                    <div class="field-input" style="line-height: 40px">
                    {{report.title}}
                    </div>
                </div>
                <div class="block-row detail-row" ng-if="submitter">
                    <div class="field-label">申请额</div>
                    <div class="field-input">
                        <p>¥ {{report.amount}}</p>
                        <a href="/reports/snapshot/{{report.id}}?tid={{template.id}}" class="btn-detail" ng-if="report.has_snapshot && path_type!='snapshot'">
                            <img src="/static/img/mod/report/24/btn-eye@2x.png" alt="">详情
                        </a>
                    </div>
                </div>
                <div class="block-row" ng-if="submitter">
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
                <div class="block-row">
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
                                        <th ng-repeat-start="col in tableItem.children" ng-if="col.type=='4'" colspan="4" >
                                            {{col.name}}
                                        </th>
                                        <th ng-repeat-end ng-if="col.type!='4'">{{col.name}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td ng-repeat-start="col in tableItem.children" ng-if="col.type=='4'">
                                            {{userProfile['nickname']}}
                                        </td>
                                         <td ng-if="col.type=='4'">
                                            {{col._combine_data_.value['cardno']}}
                                        </td>
                                        <td ng-if="col.type=='4'">
                                            {{col._combine_data_.value['bankname']}}
                                        </td>
                                        <td ng-if="col.type=='4'">
                                            {{col._combine_data_.value['subbranch']}}
                                        </td>
                                        <td ng-repeat-end ng-if="col.type=='3' || col.type=='2' || col.type=='1'">
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
                                        <td>{{categoryMap[c.category]['category_name']||'-'}}</td>
                                        <td >{{c.dt}}</td>
                                        <td>{{c.merchants}}</td>
                                        <td>{{c.notes}}</td>
                                        <td>{{c.amount}}¥ </td>
                                    </tr> 
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>合计</td>
                                        <td colspan="4" class="sum">
                                            {{report.amount}}¥ 
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
                        <div ng-repeat="(gName, fGroup) in flow">
                            <h2 ng-class="{first: $first}">{{gName}}</h2>
                            <div class="table-container">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>人员</th>
                                            <th>时间</th>
                                            <th>操作</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="f in fGroup">
                                            <td>{{f.nickname}}</td>
                                            <td>{{f.submitdt}}</td>
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
                            <a class="btn-search ui-button" ng-click="onAddCommentToReport()">提交留言</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="report-footer" ng-if="path_type!='snapshot'">
                <a href="{{document.referer}}" style="float: left" class="ui-button-border ui-button ui-button-hover btn-back-list">
                    <img src="/static/img/mod/report/36/btn-back-list@2x.png" alt="">返回列表
                </a>
                <a ng-if="buttons.has_modify" href="/reports/edit/{{report.id}}?tid={{report.template_id}}" class="ui-button-border ui-button  ui-button-hover btn-update">
                    <img src="/static/img/mod/report/24/btn-edit@2x.png" alt="">修改
                </a>
                <a ng-if="buttons.has_reject" href="javascript:void(0)"  class="ui-button-border ui-button  ui-button-hover btn-reject" ng-click="onReject(report.id)">
                    <img src="/static/img/mod/report/24/btn-reject@2x.png" alt="">退回
                </a>
                <a ng-if="buttons.has_drop" href="javascript:void(0)"  class="ui-button-border ui-button  ui-button-hover btn-drop" ng-click="onDrop(report.id)">
                    <img src="/static/img/mod/report/24/btn-reject@2x.png" alt="">撤回
                </a>
                <a ng-if="buttons.has_pass" href="javascript:void(0)" class="ui-button ui-button-hover btn-pass" ng-click="onPass(report.id)">
                    <img src="/static/img/mod/report/24/btn-pass@2x.png" alt="">通过
                </a>
                <a ng-if="buttons.has_affirm" href="javascript:void(0)" class="btn-affirm ui-button-hover ui-button" ng-click="onAffirm($event)">
                    <img src="/static/img/mod/report/24/btn-pass@2x.png" alt="">完成确认
                </a>
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
                    <ul class="stop-parent-scroll">
                        <li class="s_{{s.id}}" ng-repeat='s in suggestionMembers' ng-class="{selected: s.isSelected}"  ng-click="onSelectMember(s, $event)">
                            <img ng-src="{{s.apath || default_avatar }}" alt="">
                            <div class="info">
                                <p class="name">{{s.nickname}}</p>
                                <p class="role">{{s.d}}</p>
                            </div>
                        </li>
                        <li ng-if="suggestionMembers" class="line"></li>
                        <li class="m_{{m.id}}" ng-repeat='m in (filteredMembers = (members|filter:searchImmediate(txtSearchText)))' ng-class="{selected: m.isSelected}" ng-click="onSelectMember(m, $event)" ng-if="!m._in_sug_">
                            <img ng-src="{{m.apath || default_avatar}}" alt="">
                            <div class="info">
                                <p class="name">{{m.nickname}}</p>
                                <p class="role" ng-if="!m.multi_property_matcher">{{m.d}}</p>
                                <p class="role" ng-if="m.multi_property_matcher">{{m.multi_property_matcher}}</p>
                            </div>
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
<script src="/static/js/mod/report/show.js"></script>
<script src="/static/js/libs/route-recognizer.js"></script>
<link rel="stylesheet" href="/static/css/base/scrollbar.css">

<script src="/static/plugins/cloud-dialog/dialog.js"></script>
<link rel="stylesheet" href="/static/plugins/cloud-dialog/dialog.css">
