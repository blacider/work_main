<script src="/app/libs/angular/angular.js"></script>
<link rel="stylesheet" href="/static/css/mod/template/list.css"/>
<div class="mod mod-reim-template" ng-app="reimApp">
    <div class="page-content-area" ng-controller="templateController">
        <div class="header">
            <a href="javascript:void(0)" class="btn-add" ng-click="onAddTemplate()"></a>
        </div>
        <div class="paper" ng-class="{shrink: !$first}" ng-repeat="templateItem in templateArray" data-id="{{templateItem.id}}">
            <div class="paper-header">
                <input type="text" value="{{templateItem.name}}">
                <p class="buttons">
                    <span class="button btn-eye" ng-click="onPreviewTemplate(templateItem, $event)"></span>
                    <span class="button btn-trash" ng-click="onDeleteTemplate(templateItem, $index)"></span>
                    <span class="button btn-accordion" ng-click="onAccordionTemplate(templateItem, $index, $event)"></span>
                </p>
            </div>
            <div class="paper-content">
                <div class="title">
                    内容设置                    
                </div>
                <div class="field-table" ng-repeat="tableItem in templateItem.config">
                    <div class="line"></div>
                    <h4 class="field-table-title" >{{tableItem.name}}
                    <p class="buttons">
                        <span class="button btn-trash"></span>
                        <span class="button btn-edit"></span>
                        <span class="button btn-drag"></span>
                    </p>
                    </h4>
                    <div class="column-wrap table-layout">
                        <h4 class="field-table-label table-cell"> 字段组 </h4>
                        <div class="field-table-content table-cell">
                            <table>
                                <thead>
                                    <tr>
                                        <th ng-repeat="tableColumn in tableItem.children">{{tableColumn.name}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td ng-repeat="i in tableItem.children"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>               
                    </div>
                </div>
                <div class="field-group" ng-repeat="tableEditItem in templateEditMap[templateItem.id]">
                    <h4 class="field-group-title">
                        <div class="field-input">
                            <input type="text" placeholder="字段组名称" value="{{tableEditItem.name}}">
                        </div>
                    </h4>
                    <div class="column-wrap table-layout">
                        <h4 class="field-group-label table-cell"> 字段组 </h4>
                        <div class="field-group-rows table-cell">
                            <div class="fields field-options table-layout" ng-repeat="editColumnItem in tableEditItem.children">
                                <div class="table-cell field-name">
                                    <div class="field-input field">
                                        <input type="text" placeholder="字段组名称" value="{{editColumnItem.name}}">
                                    </div>
                                </div>
                                <div class="table-cell field-type">
                                    <div class="field-select field">
                                        <select>
                                            <option value="">类型</option>
                                            <option value="">日期</option>
                                            <option value="">银行</option>
                                            <option value="">默认</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="table-cell field-checkbox white" ng-class="{checked: editColumnItem.required}" ng-click="toggleCheckbox($event)">
                                    <input type="checkbox" tabindex="0" class="hidden" ng-value="">
                                    <label for="">必填</label>
                                </div>
                                <div class="button field table-cell">
                                    <p class="btn-trash" ng-click="onRemoveEditColumn($index)"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="field-group-footer">
                        <p class="buttons">
                            <span class="button btn-add" ng-click="onAddColumnForFieldTableConfig(templateItem, $event, $index)">添加字段</span>
                            <span class="button btn-save">保存字段</span>
                            <span class="button btn-cancel">取消</span>
                        </p>
                    </div>           
                </div>
                <div class="field-group row-group" style="padding-bottom: 0">
                    <div class="line"></div>
                    <div class="column-wrap table-layout">
                        <h4 class="field-group-label table-cell"> 字段组 </h4>
                        <div class="table-cell">
                            <a href="javascript:void(0)" class="btn-add-field-group" ng-click="onAddFieldTable(templateItem, $event, $index)"></a>
                        </div>
                    </div>
                </div>
                <div class="field-table default-field-table">
                    <div class="line"></div>
                    <h4 class="field-table-title">消费明细
                        <p class="buttons">
                            <span class="button btn-eye" ng-click="toggleTableVisible($event)"></span>
                        </p>
                    </h4>
                    <div class="column-wrap table-layout">
                        <h4 class="field-table-label table-cell"> 字段组 </h4>
                        <div class="table-cell field-table-content-multi-row">
                            <div class="field-checkbox" style="display: block; margin-bottom: 0" ng-click="toggleCheckbox($event)">
                                <input type="checkbox" tabindex="0" class="hidden">
                                <label for="">消费按类目分类</label>
                            </div>
                            <div class="field-table-content" style="margin-top: 20px;">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>日期</th>
                                            <th>商家</th>
                                            <th>人员</th>
                                            <th>备注</th>
                                            <th>金额</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>  
                        </div>             
                    </div>
                </div>
                <div class="field-table default-field-table" style="">
                    <div class="line" style="margin-bottom: 30px;"></div>
                    <div class="column-wrap table-layout">
                        <h4 class="field-table-label table-cell"> 字段组 </h4>
                        <div class="table-cell field-table-content-multi-row">
                            <h4 class="field-table-title" style="padding-left: 0; margin: 0">流转意见
                                <p class="buttons">
                                    <span class="button btn-eye" ng-click="toggleTableVisible($event)"></span>
                                </p>
                            </h4>
                            <div class="field-table-content" style="margin-top: 20px;">
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
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>  
                        </div>             
                    </div>
                </div>
                <div class="field-table default-field-table">
                    <div class="line" style="margin-bottom: 30px"></div>
                    <div class="column-wrap table-layout">
                        <h4 class="field-table-label table-cell"> 适用范围 </h4>
                        <div class="table-cell field-table-content-multi-row">
                            <div class="field-checkbox checked" ng-click="toggleCheckbox($event)">
                                <input type="checkbox" tabindex="0" class="hidden">
                                <label for="">报销</label>
                            </div>
                            <div class="field-checkbox" ng-click="toggleCheckbox($event)">
                                <input type="checkbox" tabindex="0" class="hidden">
                                <label for="">预算</label>
                            </div>
                            <div class="field-checkbox" ng-click="toggleCheckbox($event)">
                                <input type="checkbox" tabindex="0" class="hidden">
                                <label for="">预借</label>
                            </div>
                        </div>             
                    </div>
                </div>
            </div>
            <div class="field-table print-settings default-field-table">
                <div style="padding: 42px 0;">
                    <h4 class="field-table-title">打印设置
                        <p class="buttons">
                            <span class="button btn-accordion" ng-click="togglePrintSettings($event)"></span>
                        </p>
                    </h4>
                </div>
                <div class="group-container none">
                    <div class="column-wrap table-layout">
                        <h4 class="field-table-label table-cell"> 表头显示 </h4>
                        <div class="table-cell field-table-content-multi-row">
                            <div class="field-checkbox checked disabled" style="display: block" ng-click="toggleCheckbox($event)">
                                <input type="checkbox" tabindex="0" class="hidden">
                                <label for="">报销单名称</label>
                            </div>
                            <div class="field-checkbox checked disabled" ng-click="toggleCheckbox($event)">
                                <input type="checkbox" tabindex="0" class="hidden">
                                <label for="">提交时间</label>
                            </div>
                            <div class="field-checkbox checked disabled" ng-click="toggleCheckbox($event)">
                                <input type="checkbox" tabindex="0" class="hidden">
                                <label for="">提交者姓名</label>
                            </div>
                            <div class="field-checkbox checked disabled" ng-click="toggleCheckbox($event)">
                                <input type="checkbox" tabindex="0" class="hidden">
                                <label for="">金额</label>
                            </div>
                            <div class="field-checkbox" ng-click="toggleCheckbox($event)">
                                <input type="checkbox" tabindex="0" class="hidden">
                                <label for="">提交者职位</label>
                            </div>
                            <div class="field-checkbox" ng-click="toggleCheckbox($event)">
                                <input type="checkbox" tabindex="0" class="hidden">
                                <label for="">提交者部门</label>
                            </div>
                            <div class="field-checkbox" ng-click="toggleCheckbox($event)">
                                <input type="checkbox" tabindex="0" class="hidden">
                                <label for="">提交者上级部门</label>
                            </div>
                            <div class="field-checkbox" ng-click="toggleCheckbox($event)">
                                <input type="checkbox" tabindex="0" class="hidden">
                                <label for="">提交者ID</label>
                            </div>
                            <div class="field-checkbox" ng-click="toggleCheckbox($event)">
                                <input type="checkbox" tabindex="0" class="hidden">
                                <label for="">提交者电话</label>
                            </div>
                            <div class="field-checkbox" style="margin-bottom: 0;" ng-click="toggleCheckbox($event)">
                                <input type="checkbox" tabindex="0" class="hidden">
                                <label for="">提交者邮箱</label>
                            </div>
                        </div>             
                    </div>
                    <div class="column-wrap table-layout">
                        <h4 class="field-table-label table-cell"> 页脚显示 </h4>
                        <div class="table-cell field-table-content-multi-row">
                            <div class="field-checkbox checked" ng-click="toggleCheckbox($event)">
                                <input type="checkbox" tabindex="0" class="hidden">
                                <label for="">公司名称</label>
                            </div>
                            <div class="field-checkbox" style="margin-bottom: 0;" ng-click="toggleCheckbox($event)">
                                <input type="checkbox" tabindex="0" class="hidden">
                                <label for="">部门名称</label>
                            </div>
                        </div>             
                    </div>
                    <div class="column-wrap table-layout pager-size" style="border-bottom: 1px solid #f2f6fa;">
                        <h4 class="field-table-label table-cell"> 打印模版 </h4>
                        <div class="table-cell field-table-content-multi-row">
                            <div class="field-radio checked" ng-click="onRadioGroupClick($event)">
                                <input type="radio" tabindex="0" class="hidden">
                                <label for="">A4模版</label>
                            </div>
                            <div class="field-radio" ng-click="onRadioGroupClick($event)">
                                <input type="radio" tabindex="0" class="hidden">
                                <label for="">A5模版</label>
                            </div>
                            <div class="field-radio" ng-click="onRadioGroupClick($event)">
                                <input type="radio" tabindex="0" class="hidden">
                                <label for="">B5模版</label>
                            </div>
                        </div>             
                    </div>
                </div>
            </div>

            <div class="paper-footer">
                <a href="javascript:void(0)" class="btn-cancel"></a>
                <a href="javascript:void(0)" class="btn-preview"></a>
                <a href="javascript:void(0)" class="btn-save"></a>
            </div>
        </div>
    </div>
</div>
<script src="/static/js/mod/template/list.js"></script>