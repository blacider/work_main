<script src="/app/libs/angular/angular.js"></script>
<link rel="stylesheet" href="/static/css/mod/component/fields.css"/>
<link rel="stylesheet" href="/static/css/mod/member/imports-stash.css"/>
<link rel="stylesheet" href="/static/css/widgets/loading-default.css"/>

<script>
var _LOCALE_FILE_MEMBERS_ = <?php echo json_encode($locale_file_members)?>;
var _SERVER_MEMBERS_ = <?php echo json_encode($server_members)?>;
</script>

<div class="mod mod-add-report" ng-app="reimApp">
    <div class="page-content-area" ng-controller="MemberImportsController">
        <div class="ui-loading-layer" ng-if="!isLoaded">
            <div class="ui-loading-icon"></div>
        </div>
        <div class="mod-imports-stash">
            <h2>信息无效，修改后可导入（{{errorArray.length}}条）</h2>
            <div class="cbx-table-container">
                <table>
                    <thead>
                        <tr >
                            <th>ID</th>
                            <th>姓名</th>
                            <th>邮箱</th>
                            <th>手机号</th>
                            <th>银行卡号</th>
                            <th>部门</th>
                            <th>职位</th>
                            <th>默认审批人</th>
                            <th>二级审批人</th>
                            <th>三级审批人</th>
                            <th>状态</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr data-id="{{item.$$hashKey}}" ng-repeat="item in errorArray">
                            <td data-field="id" ng-class="{'field-error':  item._v_.id}">
                                <span class="field-value">{{item.id}}</span>
                                <i ng-if="item._v_.id" class="field-tip" title="{{_CONST_INPUT_CODE_[item._v_.id]}}">?</i>
                            </td>
                            <td data-field="nickname" ng-class="{'field-error':  item._v_.nickname}">
                                <span class="field-value">{{item.nickname}}</span>
                                <i ng-if="item._v_.nickname" class="field-tip" title="{{_CONST_INPUT_CODE_[item._v_.nickname]}}">?</i>
                            </td>
                            <td data-field="email" ng-class="{'field-error':  item._v_.email}">
                                <span class="field-value">{{item.email}}</span>
                                <i ng-if="item._v_.email" class="field-tip" title="{{_CONST_INPUT_CODE_[item._v_.email]}}">?</i>
                            </td>
                            <td data-field="phone" ng-class="{'field-error':  item._v_.phone}">
                                <span class="field-value">{{item.phone}}</span>
                                <i ng-if="item._v_.phone" class="field-tip" title="{{_CONST_INPUT_CODE_[item._v_.phone]}}">?</i>
                            </td>
                            <td data-field="cardno" ng-class="{'field-error':  item._v_.cardno}">
                                <span class="field-value">{{item.cardno}}</span>
                                <i ng-if="item._v_.cardno" class="field-tip" title="{{_CONST_INPUT_CODE_[item._v_.cardno]}}">?</i>
                            </td>
                            <td data-field="gid" ng-class="{'field-error':  item._v_.gid}">
                                <span class="field-value">{{item.gid}}</span>
                                <i ng-if="item._v_.gid" class="field-tip" title="{{_CONST_INPUT_CODE_[item._v_.gid]}}">?</i>
                            </td>
                            <td data-field="manager_id" ng-class="{'field-error':  item._v_.manager_id}">
                                <span class="field-value">{{item.manager_id}}</span>
                                <i ng-if="item._v_.manager_id" class="field-tip" title="{{_CONST_INPUT_CODE_[item._v_.manager_id]}}">?</i>
                            </td>
                            <td data-field="rank" ng-class="{'field-error':  item._v_.rank}">
                                <span class="field-value">{{item.rank}}</span>
                                <i ng-if="item._v_.rank" class="field-tip" title="{{_CONST_INPUT_CODE_[item._v_.rank]}}">?</i>
                            </td>

                            <td>-</td>
                            <td>-</td>
                            <td>
                                无法导入{{item.$$hashKey}}
                            </td>
                        </tr> 
                    </tbody>
                </table>
            </div>
            <h2>将新增的员工信息（{{appenderArray.length}}条）</h2>
            <div class="cbx-table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>姓名</th>
                            <th>邮箱</th>
                            <th>手机号</th>
                            <th>银行卡号</th>
                            <th>部门</th>
                            <th>职位</th>
                            <th>默认审批人</th>
                            <th>二级审批人</th>
                            <th>三级审批人</th>
                            <th>状态</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr data-id="{{item.$$hashKey}}" ng-repeat="item in appenderArray">
                            <td data-field="id" ng-class="{'field-error':  item._v_.id}">
                                <span class="field-value">{{item.id}}</span>
                                <i ng-if="item._v_.id" class="field-tip" title="{{_CONST_INPUT_CODE_[item._v_.id]}}">?</i>
                            </td>
                            <td data-field="nickname" ng-class="{'field-error':  item._v_.nickname}">
                                <span class="field-value">{{item.nickname}}</span>
                                <i ng-if="item._v_.nickname" class="field-tip" title="{{_CONST_INPUT_CODE_[item._v_.nickname]}}">?</i>
                            </td>
                            <td data-field="email" ng-class="{'field-error':  item._v_.email}">
                                <span class="field-value">{{item.email}}</span>
                                <i ng-if="item._v_.email" class="field-tip" title="{{_CONST_INPUT_CODE_[item._v_.email]}}">?</i>
                            </td>
                            <td data-field="phone" ng-class="{'field-error':  item._v_.phone}">
                                <span class="field-value">{{item.phone}}</span>
                                <i ng-if="item._v_.phone" class="field-tip" title="{{_CONST_INPUT_CODE_[item._v_.phone]}}">?</i>
                            </td>
                            <td data-field="cardno" ng-class="{'field-error':  item._v_.cardno}">
                                <span class="field-value">{{item.cardno}}</span>
                                <i ng-if="item._v_.cardno" class="field-tip" title="{{_CONST_INPUT_CODE_[item._v_.cardno]}}">?</i>
                            </td>
                            <td>
                                {{item.dept}}
                            </td>
                            <td>
                                {{item.rank}}
                            </td>
                            <td>
                                -
                            </td>
                            <td>
                                -
                            </td>
                            <td>
                                -
                            </td>
                            <td>
                                待提交{{item.$$hashKey}}
                            </td>
                        </tr> 
                    </tbody>
                </table>
            </div>
            <h2>将更新员工信息（{{modifierArray.length}}条）蓝色为更新信息，修改错误的红色信息后可提交该条信息</h2>
            <div class="cbx-table-container table-modified">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>姓名</th>
                            <th>邮箱</th>
                            <th>手机号</th>
                            <th>银行卡号</th>
                            <th>部门</th>
                            <th>职位</th>
                            <th>默认审批人</th>
                            <th>二级审批人</th>
                            <th>三级审批人</th>
                            <th>状态</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr data-id="{{item.$$hashKey}}" ng-repeat="item in modifierArray">
                            <td data-field="id" ng-class="{'field-error': item._v_.id!='MODIFIED' && item._v_.id, 'field-modified': item._v_.id=='MODIFIED'}">
                                <span class="field-value">{{item.id}}</span>
                                <i ng-if="item._v_.id" class="field-tip" title="{{_CONST_INPUT_CODE_[item._v_.id]}}">?</i>
                            </td>
                            <td data-field="nickname" ng-class="{'field-error': item._v_.nickname!='MODIFIED' && item._v_.nickname, 'field-modified': item._v_.nickname=='MODIFIED'}">
                                <span class="field-value">{{item.nickname}}</span>
                                <i ng-if="item._v_.nickname" class="field-tip" title="{{_CONST_INPUT_CODE_[item._v_.nickname]}}">?</i>
                            </td>
                            <td data-field="email" ng-class="{'field-error': item._v_.email!='MODIFIED' && item._v_.email, 'field-modified': item._v_.email=='MODIFIED'}">
                                <span class="field-value">{{item.email}}</span>
                                <i ng-if="item._v_.email" class="field-tip" title="{{_CONST_INPUT_CODE_[item._v_.email]}}">?</i>
                            </td>
                            <td data-field="phone" ng-class="{'field-error': item._v_.phone!='MODIFIED' && item._v_.phone, 'field-modified': item._v_.phone=='MODIFIED'}">
                                <span class="field-value">{{item.phone}}</span>
                                <i ng-if="item._v_.phone!='MODIFIED'" class="field-tip" title="{{_CONST_INPUT_CODE_[item._v_.phone]}}">?</i>
                            </td>
                            <td>
                                {{item.cardno}}
                            </td>
                            <td>
                                {{item.dept}}
                            </td>
                            <td>
                                {{item.rank}}
                            </td>
                            <td>
                                -
                            </td>
                            <td>
                                -
                            </td>
                            <td>
                                -
                            </td>
                            <td>
                                待提交{{item.$$hashKey}}
                            </td>
                        </tr> 
                    </tbody>
                </table>
            </div>
            <div style="text-align: right; padding-top: 12px;">
                <button class="btn-submit ui-button">取消</button>
                <button class="btn-submit ui-button">确定导入</button>
            </div>

        </div>  
    </div>
</div>

<script src="/static/js/libs/underscore-min.js"></script>
<script src="/static/js/jquery.cookie.js"></script>
<script src="/static/js/mod/member/imports-stash.js"></script>

<script src="/static/plugins/art-dialog/art-dialog.min.js"></script>
<link rel="stylesheet" href="/static/plugins/art-dialog/ui-dialog.css">
<link rel="stylesheet" href="/static/plugins/art-dialog/ui-dialog-reset.css">


