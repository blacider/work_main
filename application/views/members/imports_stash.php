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
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="item in errorArray">
                            <td>
                                <input type="text" value="{{item.id}}">
                            </td>
                            <td title="" ng-class="{error: 1}">
                                {{item.nickname}}
                            </td>
                            <td>
                            {{item.email}}
                            </td>
                            <td>
                            {{item.phone}}
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
                            <th>银行卡号</th>
                            <th>部门</th>
                            <th>职位</th>
                            <th>默认审批人</th>
                            <th>二级审批人</th>
                            <th>三级审批人</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="item in appenderArray">
                            <td>
                                {{item.id}}
                            </td>
                            <td>
                                {{item.nickname}}
                            </td>
                            <td>
                            {{item.email}}
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
                        </tr> 
                    </tbody>
                </table>
            </div>
            <h2>将更新员工信息（{{modifierArray.length}}条）蓝色为更新信息，修改错误的红色信息后可提交该条信息</h2>
            <div class="cbx-table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>姓名</th>
                            <th>邮箱</th>
                            <th>银行卡号</th>
                            <th>部门</th>
                            <th>职位</th>
                            <th>默认审批人</th>
                            <th>二级审批人</th>
                            <th>三级审批人</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="item in modifierArray">
                            <td>
                                {{item.id}}
                            </td>
                            <td>
                                {{item.nickname}}
                            </td>
                            <td>
                            {{item.email}}
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
                        </tr> 
                    </tbody>
                </table>
            </div>
        </div>  
    </div>
</div>

<script src="/static/js/libs/underscore-min.js"></script>
<script src="/static/js/jquery.cookie.js"></script>
<script src="/static/js/mod/member/imports-stash.js"></script>

