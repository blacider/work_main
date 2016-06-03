<script src="/app/libs/angular/angular.js"></script>
<link rel="stylesheet" href="/static/css/mod/component/fields.css"/>
<link rel="stylesheet" href="/static/css/mod/member/imports-stash.css"/>
<link rel="stylesheet" href="/static/css/widgets/loading-default.css"/>

<script>
var _LOCALE_FILE_MEMBERS_ = <?php echo json_encode($locale_file_members)?>;
var _SERVER_MEMBERS_ = <?php echo json_encode($server_members)?>;
var _SERVER_RANKS_ = <?php echo json_encode($ranks)?>;
var _SERVER_LEVELS_ = <?php echo json_encode($levels)?>;
var _SERVER_GROUPS_ = <?php echo json_encode($groups)?>;
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
                            <th>银行名</th>
                            <th>部门</th>
                            <th>级别</th>
                            <th>职位</th>
                            <th>默认审批人</th>
                            <th>二级审批人</th>
                            <th>三级审批人</th>
                            <th>状态</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr data-id="{{item.$$hashKey}}" ng-repeat="item in errorArray">
                            <td data-field="id" ng-class="{'field-error': item._v_.id!='MODIFIED' && item._v_.id, 'field-modified': item._v_.id=='MODIFIED'}">
                                <span class="field-value">{{item.id}}</span>
                                <i ng-if="item._v_.id && item._v_.id!='MODIFIED'"  class="btn-edit icon"></i>
                                <i ng-if="item._v_.id && item._v_.id!='MODIFIED'" class="field-tip" data-title="{{_CONST_INPUT_CODE_[item._v_.id]}}">?</i>
                            </td>
                            <td data-field="nickname" ng-class="{'field-error': item._v_.nickname!='MODIFIED' && item._v_.nickname, 'field-modified': item._v_.nickname=='MODIFIED'}">
                                <span class="field-value">{{item.nickname}}</span>
                                <i ng-if="item._v_.nickname && item._v_.nickname!='MODIFIED'"  class="btn-edit icon"></i>
                                <i ng-if="item._v_.nickname && item._v_.nickname!='MODIFIED'" class="field-tip" data-title="{{_CONST_INPUT_CODE_[item._v_.nickname]}}">?</i>
                            </td>
                            <td data-field="email" ng-class="{'field-error': item._v_.email!='MODIFIED' && item._v_.email, 'field-modified': item._v_.email=='MODIFIED'}">
                                <span class="field-value">{{item.email}}</span>
                                <i ng-if="item._v_.email && item._v_.email!='MODIFIED'"  class="btn-edit icon"></i>
                                <i ng-if="item._v_.email && item._v_.email!='MODIFIED'" class="field-tip" data-title="{{_CONST_INPUT_CODE_[item._v_.email]}}">?</i>
                            </td>
                            <td data-field="phone" ng-class="{'field-error': item._v_.phone!='MODIFIED' && item._v_.phone, 'field-modified': item._v_.phone=='MODIFIED'}">
                                <span class="field-value">{{item.phone}}</span>
                                <i ng-if="item._v_.phone && item._v_.phone!='MODIFIED'"  class="btn-edit icon"></i>
                                <i ng-if="item._v_.phone && item._v_.phone!='MODIFIED'" class="field-tip" data-title="{{_CONST_INPUT_CODE_[item._v_.phone]}}">?</i>
                            </td>
                            <td data-field="cardno" ng-class="{'field-error': item._v_.cardno!='MODIFIED' && item._v_.cardno, 'field-modified': item._v_.cardno=='MODIFIED'}">
                                <span class="field-value">{{item.cardno}}</span>
                                <i ng-if="item._v_.cardno && item._v_.cardno!='MODIFIED'"  class="btn-edit icon"></i>
                                <i ng-if="item._v_.cardno && item._v_.cardno!='MODIFIED'" class="field-tip" data-title="{{_CONST_INPUT_CODE_[item._v_.cardno]}}">?</i>
                            </td>
                            <td data-field="bank" ng-class="{'field-error': item._v_.bank!='MODIFIED' && item._v_.bank, 'field-modified': item._v_.bank=='MODIFIED'}">
                                <span class="field-value">{{item.bank}}</span>
                                <i ng-if="item._v_.bank && item._v_.bank!='MODIFIED'"  class="btn-edit icon"></i>
                                <i ng-if="item._v_.bank && item._v_.bank!='MODIFIED'" class="field-tip" data-title="{{_CONST_INPUT_CODE_[item._v_.bank]}}">?</i>
                            </td>
                            <td data-field="gids" ng-class="{'field-error': item._v_.gids!='MODIFIED' && item._v_.gids, 'field-modified': item._v_.gids=='MODIFIED'}">
                                <span class="field-value">{{item.gids}}</span>
                                <i ng-if="item._v_.gids && item._v_.gids!='MODIFIED'"  class="btn-edit icon"></i>
                                <i ng-if="item._v_.gids && item._v_.gids!='MODIFIED'" class="field-tip" data-title="{{_CONST_INPUT_CODE_[item._v_.gids]}}">?</i>
                            </td>
                            <td data-field="level" ng-class="{'field-error': item._v_.level!='MODIFIED' && item._v_.level, 'field-modified': item._v_.level=='MODIFIED'}">
                                <span class="field-value">{{item.level}}</span>
                                <i ng-if="item._v_.level && item._v_.level!='MODIFIED'"  class="btn-edit icon"></i>
                                <i ng-if="item._v_.level && item._v_.level!='MODIFIED'" class="field-tip" data-title="{{_CONST_INPUT_CODE_[item._v_.level]}}">?</i>
                            </td>
                            <td data-field="rank" ng-class="{'field-error': item._v_.rank!='MODIFIED' && item._v_.rank, 'field-modified': item._v_.rank=='MODIFIED'}">
                                <span class="field-value">{{item.rank}}</span>
                                <i ng-if="item._v_.rank && item._v_.rank!='MODIFIED'"  class="btn-edit icon"></i>
                                <i ng-if="item._v_.rank && item._v_.rank!='MODIFIED'" class="field-tip" data-title="{{_CONST_INPUT_CODE_[item._v_.rank]}}">?</i>
                            </td>
                            <td data-field="manager_id" ng-class="{'field-error': item._v_.manager_id!='MODIFIED' && item._v_.manager_id, 'field-modified': item._v_.manager_id=='MODIFIED'}">
                                <span class="field-value">{{item.manager_id}}</span>
                                <i ng-if="item._v_.manager_id && item._v_.manager_id!='MODIFIED'"  class="btn-edit icon"></i>
                                <i ng-if="item._v_.manager_id && item._v_.manager_id!='MODIFIED'" class="field-tip" data-title="{{_CONST_INPUT_CODE_[item._v_.manager_id]}}">?</i>
                            </td>
                            <td data-field="manager_id_2">
                                <span class="field-value">{{item.manager_id_2}}</span>
                            </td>
                            <td data-field="manager_id_3">
                                <span class="field-value">{{item.manager_id_3}}</span>
                            </td>
                            <td ng-class="{'field-padding': item._status_tip_}">
                                <span ng-class="{'can-import': item._status_==1}">
                                    {{item._status_text_ || '无法导入'}}
                                </span>
                                <i ng-if="item._status_tip_" class="field-tip" data-title="{{item._status_tip_}}">?</i>
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
                            <th>银行名</th>
                            <th>部门</th>
                            <th>级别</th>
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
                                <i ng-if="item._v_.id" class="btn-edit icon"></i>
                                <i ng-if="item._v_.id" class="field-tip" data-title="{{_CONST_INPUT_CODE_[item._v_.id]}}">?</i>
                            </td>
                            <td data-field="nickname" ng-class="{'field-error':  item._v_.nickname}">
                                <span class="field-value">{{item.nickname}}</span>
                                <i ng-if="item._v_.nickname" class="btn-edit icon"></i>
                                <i ng-if="item._v_.nickname" class="field-tip" data-title="{{_CONST_INPUT_CODE_[item._v_.nickname]}}">?</i>
                            </td>
                            <td data-field="email" ng-class="{'field-error':  item._v_.email}">
                                <span class="field-value">{{item.email}}</span>
                                <i ng-if="item._v_.email" class="btn-edit icon"></i>
                                <i ng-if="item._v_.email" class="field-tip" data-title="{{_CONST_INPUT_CODE_[item._v_.email]}}">?</i>
                            </td>
                            <td data-field="phone" ng-class="{'field-error':  item._v_.phone}">
                                <span class="field-value">{{item.phone}}</span>
                                <i ng-if="item._v_.phone" class="btn-edit icon"></i>
                                <i ng-if="item._v_.phone" class="field-tip" data-title="{{_CONST_INPUT_CODE_[item._v_.phone]}}">?</i>
                            </td>
                            <td data-field="cardno" ng-class="{'field-error':  item._v_.cardno}">
                                <span class="field-value">{{item.cardno}}</span>
                                <i ng-if="item._v_.cardno" class="btn-edit icon"></i>
                                <i ng-if="item._v_.cardno" class="field-tip" data-title="{{_CONST_INPUT_CODE_[item._v_.cardno]}}">?</i>
                            </td>
                            <td data-field="bank" ng-class="{'field-error':  item._v_.bank}">
                                <span class="field-value">{{item.bank}}</span>
                                <i ng-if="item._v_.bank" class="btn-edit icon"></i>
                                <i ng-if="item._v_.bank" class="field-tip" data-title="{{_CONST_INPUT_CODE_[item._v_.bank]}}">?</i>
                            </td>
                            <td data-field="gids" ng-class="{'field-error':  item._v_.gids}">
                                <span class="field-value">{{item.gids}}</span>
                                <i ng-if="item._v_.gids" class="btn-edit icon"></i>
                                <i ng-if="item._v_.gids" class="field-tip" data-title="{{_CONST_INPUT_CODE_[item._v_.gids]}}">?</i>
                            </td>
                            <td data-field="level" ng-class="{'field-error':  item._v_.level}">
                                <span class="field-value">{{item.level}}</span>
                                <i ng-if="item._v_.level" class="btn-edit icon"></i>
                                <i ng-if="item._v_.level" class="field-tip" data-title="{{_CONST_INPUT_CODE_[item._v_.level]}}">?</i>
                            </td>
                            <td data-field="rank" ng-class="{'field-error':  item._v_.rank}">
                                <span class="field-value">{{item.rank}}</span>
                                <i ng-if="item._v_.rank" class="btn-edit icon"></i>
                                <i ng-if="item._v_.rank" class="field-tip" data-title="{{_CONST_INPUT_CODE_[item._v_.rank]}}">?</i>
                            </td>
                            <td data-field="manager_id" ng-class="{'field-error':  item._v_.manager_id}">
                                <span class="field-value">{{item.manager_id}}</span>
                                <i ng-if="item._v_.manager_id" class="btn-edit icon"></i>
                                <i ng-if="item._v_.manager_id" class="field-tip" data-title="{{_CONST_INPUT_CODE_[item._v_.manager_id]}}">?</i>
                            </td>
                            <td data-field="manager_id_2">
                                <span class="field-value">{{item.manager_id_2}}</span>
                            </td>
                            <td data-field="manager_id_3">
                                <span class="field-value">{{item.manager_id_3}}</span>
                            </td>
                            <td ng-class="{'field-padding': item._status_tip_}">
                                <span ng-class="{'can-import': item._status_==1}">
                                    {{item._status_text_ || '无法导入'}}
                                </span>
                                <i ng-if="item._status_tip_" class="field-tip" data-title="{{item._status_tip_}}">?</i>
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
                            <th>ID</th> <!-- id -->
                            <th>姓名</th> <!-- nickname -->
                            <th>邮箱</th> <!-- email -->
                            <th>手机号</th> <!-- phone -->
                            <th>银行卡号</th> <!-- cardno -->
                            <th>银行名</th> <!-- cardno -->
                            <th>部门</th> <!-- gids -->
                            <th>级别</th> <!-- level -->
                            <th>职位</th> <!-- rank -->
                            <th>默认审批人</th> <!-- manager -->
                            <th>二级审批人</th> <!-- api not support -->
                            <th>三级审批人</th> <!-- api not support -->
                            <th>状态</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr data-id="{{item.$$hashKey}}" ng-repeat="item in modifierArray">
                            <td data-field="id" ng-class="{'field-error': item._v_.id!='MODIFIED' && item._v_.id, 'field-modified': item._v_.id=='MODIFIED'}">
                                <span class="field-value">{{item.id}}</span>
                                <i ng-if="item._v_.id && item._v_.id!='MODIFIED'"  class="btn-edit icon"></i>
                                <i ng-if="item._v_.id && item._v_.id!='MODIFIED'" class="field-tip" data-title="{{_CONST_INPUT_CODE_[item._v_.id]}}">?</i>
                            </td>
                            <td data-field="nickname" ng-class="{'field-error': item._v_.nickname!='MODIFIED' && item._v_.nickname, 'field-modified': item._v_.nickname=='MODIFIED'}">
                                <span class="field-value">{{item.nickname}}</span>
                                <i ng-if="item._v_.nickname && item._v_.nickname!='MODIFIED'"  class="btn-edit icon"></i>
                                <i ng-if="item._v_.nickname && item._v_.nickname!='MODIFIED'" class="field-tip" data-title="{{_CONST_INPUT_CODE_[item._v_.nickname]}}">?</i>
                            </td>
                            <td data-field="email" ng-class="{'field-error': item._v_.email!='MODIFIED' && item._v_.email, 'field-modified': item._v_.email=='MODIFIED'}">
                                <span class="field-value">{{item.email}}</span>
                                <i ng-if="item._v_.email && item._v_.email!='MODIFIED'"  class="btn-edit icon"></i>
                                <i ng-if="item._v_.email && item._v_.email!='MODIFIED'" class="field-tip" data-title="{{_CONST_INPUT_CODE_[item._v_.email]}}">?</i>
                            </td>
                            <td data-field="phone" ng-class="{'field-error': item._v_.phone!='MODIFIED' && item._v_.phone, 'field-modified': item._v_.phone=='MODIFIED'}">
                                <span class="field-value">{{item.phone}}</span>
                                <i ng-if="item._v_.phone && item._v_.phone!='MODIFIED'"  class="btn-edit icon"></i>
                                <i ng-if="item._v_.phone && item._v_.phone!='MODIFIED'" class="field-tip" data-title="{{_CONST_INPUT_CODE_[item._v_.phone]}}">?</i>
                            </td>
                            <td data-field="cardno" ng-class="{'field-error': item._v_.cardno!='MODIFIED' && item._v_.cardno, 'field-modified': item._v_.cardno=='MODIFIED'}">
                                <span class="field-value">{{item.cardno}}</span>
                                <i ng-if="item._v_.cardno && item._v_.cardno!='MODIFIED'"  class="btn-edit icon"></i>
                                <i ng-if="item._v_.cardno && item._v_.cardno!='MODIFIED'" class="field-tip" data-title="{{_CONST_INPUT_CODE_[item._v_.cardno]}}">?</i>
                            </td>
                            <td data-field="bank" ng-class="{'field-error': item._v_.bank!='MODIFIED' && item._v_.bank, 'field-modified': item._v_.bank=='MODIFIED'}">
                                <span class="field-value">{{item.bank}}</span>
                                <i ng-if="item._v_.bank && item._v_.bank!='MODIFIED'"  class="btn-edit icon"></i>
                                <i ng-if="item._v_.bank && item._v_.bank!='MODIFIED'" class="field-tip" data-title="{{_CONST_INPUT_CODE_[item._v_.bank]}}">?</i>
                            </td>
                            <td data-field="gids" ng-class="{'field-error': item._v_.gids!='MODIFIED' && item._v_.gids, 'field-modified': item._v_.gids=='MODIFIED'}">
                                <span class="field-value">{{item.gids}}</span>
                                <i ng-if="item._v_.gids && item._v_.gids!='MODIFIED'"  class="btn-edit icon"></i>
                                <i ng-if="item._v_.gids && item._v_.gids!='MODIFIED'" class="field-tip" data-title="{{_CONST_INPUT_CODE_[item._v_.gids]}}">?</i>
                            </td>
                            <td data-field="level" ng-class="{'field-error': item._v_.level!='MODIFIED' && item._v_.level, 'field-modified': item._v_.level=='MODIFIED'}">
                                <span class="field-value">{{item.level}}</span>
                                <i ng-if="item._v_.level && item._v_.level!='MODIFIED'"  class="btn-edit icon"></i>
                                <i ng-if="item._v_.level && item._v_.level!='MODIFIED'" class="field-tip" data-title="{{_CONST_INPUT_CODE_[item._v_.level]}}">?</i>
                            </td>
                            <td data-field="rank" ng-class="{'field-error': item._v_.rank!='MODIFIED' && item._v_.rank, 'field-modified': item._v_.rank=='MODIFIED'}">
                                <span class="field-value">{{item.rank}}</span>
                                <i ng-if="item._v_.rank && item._v_.rank!='MODIFIED'"  class="btn-edit icon"></i>
                                <i ng-if="item._v_.rank && item._v_.rank!='MODIFIED'" class="field-tip" data-title="{{_CONST_INPUT_CODE_[item._v_.rank]}}">?</i>
                            </td>
                            <td data-field="manager_id" ng-class="{'field-error': item._v_.manager_id!='MODIFIED' && item._v_.manager_id, 'field-modified': item._v_.manager_id=='MODIFIED'}">
                                <span class="field-value">{{item.manager_id}}</span>
                                <i ng-if="item._v_.manager_id && item._v_.manager_id!='MODIFIED'"  class="btn-edit icon"></i>
                                <i ng-if="item._v_.manager_id && item._v_.manager_id!='MODIFIED'" class="field-tip" data-title="{{_CONST_INPUT_CODE_[item._v_.manager_id]}}">?</i>
                            </td>
                            <td data-field="manager_id_2">
                                <span class="field-value">{{item.manager_id_2}}</span>
                            </td>
                            <td data-field="manager_id_3">
                                <span class="field-value">{{item.manager_id_3}}</span>
                            </td>
                            <td ng-class="{'field-padding': item._status_tip_}">
                                <span ng-class="{'can-import': item._status_==1}">
                                    {{item._status_text_ || '无法导入'}}
                                </span>
                                <i ng-if="item._status_tip_" class="field-tip" data-title="{{item._status_tip_}}">?</i>
                            </td>
                        </tr> 
                    </tbody>
                </table>
            </div>
            <div style="text-align: right; padding-top: 12px;">
                <label ng-if="!isSubmitDone" style="margin-right: 12px;">
                    <input type="checkbox" ng-model="isSendEmail">
                    给新导入的员工发送通知
                </label>
                <button class="btn-submit ui-button" ng-click="onSubmit(isSendEmail, $event)">{{isSubmitDone?'完成':'确定导入'}}</button>
            </div>

        </div>  
    </div>
</div>

<script src="/static/js/libs/underscore-min.js"></script>
<script src="/static/js/jquery.cookie.js"></script>
<script src="<?= static_url("/static/js/mod/member/imports-stash.js") ?>"></script>

<script src="/static/plugins/art-dialog/art-dialog.min.js"></script>
<link rel="stylesheet" href="/static/plugins/art-dialog/ui-dialog.css">
<link rel="stylesheet" href="/static/plugins/art-dialog/ui-dialog-reset.css">


