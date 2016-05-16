<script src="/app/libs/angular/angular.js"></script>
<link rel="stylesheet" href="/static/css/mod/component/fields.css"/>
<link rel="stylesheet" href="/static/css/mod/member/imports-stash.css"/>
<link rel="stylesheet" href="/static/css/widgets/loading-default.css"/>

<script>
    var _CONST_MEMBERS_ = [];
    _CONST_MEMBERS_ = <?php echo json_encode($members)?>;
</script>

<div class="mod mod-add-report" ng-app="reimApp">
    <div class="page-content-area" ng-controller="MemberImportsController">
        <div class="ui-loading-layer" ng-if="!isLoaded">
            <div class="ui-loading-icon"></div>
        </div>
        <div class="mod-imports-stash">
            <h2>新增员工22条</h2>
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
                        <tr ng-repeat="item in members" >
                            <td>
                                {{item.nickname}}
                            </td>
                            <td>
                                {{item.nickname}}
                            </td>
                            <td>
                                {{item.nickname}}
                            </td>
                            <td>
                                {{item.nickname}}
                            </td>
                            <td>
                                {{item.nickname}}
                            </td>
                            <td>
                                {{item.nickname}}
                            </td>
                            <td>
                                {{item.nickname}}
                            </td>
                            <td>
                                {{item.nickname}}
                            </td>
                            <td>
                                {{item.nickname}}
                            </td>
                        </tr> 
                    </tbody>
                </table>
            </div>
            <h2>更新员工信息22条</h2>
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
                        <tr ng-repeat="item in members" >
                            <td>
                                {{item.nickname}}
                            </td>
                            <td>
                                {{item.nickname}}
                            </td>
                            <td>
                                {{item.nickname}}
                            </td>
                            <td>
                                {{item.nickname}}
                            </td>
                            <td>
                                {{item.nickname}}
                            </td>
                            <td>
                                {{item.nickname}}
                            </td>
                            <td>
                                {{item.nickname}}
                            </td>
                            <td>
                                {{item.nickname}}
                            </td>
                            <td>
                                {{item.nickname}}
                            </td>
                        </tr> 
                    </tbody>
                </table>
            </div>
            <h2>未能导入员工10条，错误信息（红色）如下，点击可修改</h2>
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
                        <tr ng-repeat="item in members" >
                            <td>
                                {{item.nickname}}
                            </td>
                            <td>
                                {{item.nickname}}
                            </td>
                            <td>
                                {{item.nickname}}
                            </td>
                            <td>
                                {{item.nickname}}
                            </td>
                            <td>
                                {{item.nickname}}
                            </td>
                            <td>
                                {{item.nickname}}
                            </td>
                            <td>
                                {{item.nickname}}
                            </td>
                            <td>
                                {{item.nickname}}
                            </td>
                            <td>
                                {{item.nickname}}
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

