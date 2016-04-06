<script src="/app/libs/angular/angular.js"></script>
<link rel="stylesheet" href="/static/css/mod/component/fields.css"/>
<link rel="stylesheet" href="/static/css/mod/report/show.css"/>
<link rel="stylesheet" href="/static/css/widgets/loading-default.css"/>
<div class="mod mod-show-report" ng-app="reimApp">
    <div class="page-content-area" ng-controller="ReportController">
        <div class="ui-loading-layer" ng-if="!isLoaded">
            <div class="ui-loading-icon"></div>
        </div>
        <div class="report" data-tid="<?php echo $template_id;?>" data-type="{{template.type.join(',')}}" data-status="{{report_status}}">
            <div class="report-header">
                借款单
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
                        <a href="javascript:void(0)" class="btn-detail">
                            <img src="/static/img/mod/report/24/btn-eye@2x.png" alt="">详情
                        </a>
                    </div>
                </div>
                <div class="block-row" ng-if="submitter">
                    <div class="field-label">提交人</div>
                    <div class="approvers selected-members">
                        <ul>
                            <li>
                                <img ng-src="{{submitter.apath || default_avatar}}" alt="">
                                <div class="info">
                                    <div class="name">{{submitter.nickname}}</div>
                                    <div class="role">{{formatMember(submitter)}}</div>
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
                                    <div class="role">{{formatMember(m)}}</div>
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
                                            {{col._combine_data_.value['account']}}
                                        </td>
                                        <td ng-if="col.type=='4'">
                                            {{col._combine_data_.value['bankname']}}
                                        </td>
                                        <td ng-if="col.type=='4'">
                                            {{col._combine_data_.value['bankloc']}}
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
                                        <td>{{c.category}} 报销单ID{{c.rid}}</td>
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
                <div class="block-row flow">
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
                <div class="block-row flow">
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
                                <input type="text" placeholder="" ng-model="txtCommentMessage">
                            </div>
                            <a class="btn-search ui-button" ng-click="onAddCommentToReport()">提交留言</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="report-footer">
                <a href="/reports/index" style="float: left" class="ui-button-border ui-button ui-button-hover btn-back-list">
                    <img src="/static/img/mod/report/36/btn-back-list@2x.png" alt="">返回列表
                </a>
                <a href="/reports/edit/{{report.id}}?tid={{report.template_id}}" class="ui-button-border ui-button  ui-button-hover btn-update">
                    <img src="/static/img/mod/report/24/btn-edit@2x.png" alt="">修改
                </a>
                <a href="javascript:void(0)"  class="ui-button-border ui-button  ui-button-hover btn-reject" ng-click="onReject(report.id)">
                    <img src="/static/img/mod/report/24/btn-reject@2x.png" alt="">退回
                </a>
                <a href="javascript:void(0)" class="ui-button ui-button-hover btn-pass" ng-click="onPass(report.id)">
                    <img src="/static/img/mod/report/24/btn-pass@2x.png" alt="">通过
                </a>
            </div>

             <!-- 接口太慢，预先加载公司成员，隐藏于此 -->
            <div style="display: none">
                <div class="approvers available-members">
                    <div class="search-input">
                        <div class="field-input">
                            <input type="text" placeholder="姓名／手机／邮箱" ng-model="search.$">
                        </div>
                        <a href="javascript:void(0)" class="btn-search ui-button" ng-click="">搜索</a>
                    </div>
                    <ul>
                        <li ng-repeat='m in members|filter:search' ng-init="m['show_info'] = formatMember(m)" ng-class="{selected: m.isSelected}" ng-click="onSelectMember(m, $event)">
                            <img ng-src="{{m.apath || '/static/img/mod/report/default-avatar.png'}}" alt="">
                            <div class="info">
                                <p class="name">{{m.nickname}}</p>
                                <p class="role">{{formatMember(m)}}</p>
                            </div>
                        </li>
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
