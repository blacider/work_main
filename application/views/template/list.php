<script src="/app/libs/angular/angular.js"></script>
<link rel="stylesheet" href="/static/css/mod/template/list.css"/>
<div class="mod mod-reim-template" ng-app="reimApp">
    <div class="page-content-area" ng-controller="templateController">
        <div class="header">
            <a href="javascript:void(0)" class="btn-add" ng-click="onAddTemplate()"></a>
        </div>
        <div class="paper" ng-class="{shrink: !$first}" ng-repeat="templateItem in templateArray" data-id="{{templateItem.id}}">
            <div class="paper-header">
                <input type="text" ng-model="templateItem.name">
                <p class="buttons">
                    <span class="button btn-eye" ng-click="onPreviewTemplate($index, $event)"></span>
                    <span class="button btn-trash" ng-click="onRemoveTemplate(templateItem, $index)"></span>
                    <span class="button btn-accordion" ng-click="onAccordionTemplate(templateItem, $index, $event)"></span>
                </p>
            </div>
            <div class="paper-content">
                <div class="title">
                    内容设置
                </div>
                <div class="field-table" ng-repeat="tableItem in templateItem.config">
                    <div class="line"></div>
                    <h4 class="field-table-title">{{tableItem.name}}
                        <p class="buttons">
                            <span class="button btn-trash" ng-click="onRemoveTable($event, $index, $parent.$index)"></span>
                            <span class="button btn-edit" ng-click="onEditTable($event, $index, $parent.$index)"></span>
                            <span class="button btn-drag" ng-click="onDragTable($event, $index, $parent.$index)"></span>
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
                <div class="field-group" ng-if="templateEditTableMap[templateItem.id]">
                    <h4 class="field-group-title">
                        <div class="field-input">
                            <input type="text" placeholder="字段组名称" ng-model="tableEditItem.name">
                        </div>
                    </h4>
                    <div class="column-wrap table-layout">
                        <h4 class="field-group-label table-cell"> 字段组 </h4>
                        <div class="field-group-rows table-cell">
                            <div class="fields field-options table-layout" ng-repeat="editColumnItem in templateEditTableMap[templateItem.id].children">
                                <div class="table-cell field-name">
                                    <div class="field-input field">
                                        <input type="text" placeholder="字段名称" value="{{editColumnItem.name}}">
                                    </div>
                                </div>
                                <div class="table-cell field-type">
                                    <div class="field-select field">
                                        <select>
                                            <option value="">类型</option>
                                            <option value="">文本框</option>
                                            <option value="">单选框</option>
                                            <option value="">日期选择</option>
                                            <option value="">银行账户</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="table-cell field-checkbox white" ng-class="{checked: editColumnItem.required}" ng-click="toggleCheckbox($event)">
                                    <input type="checkbox" class="hidden" ng-value="">
                                    <label for="{{labelForId}}">必填</label>
                                </div>
                                <div class="button field table-cell">
                                    <p class="btn-trash" ng-click="onRemoveColumnEditConfig(templateItem, $event, $index, $parent.$index)"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="field-group-footer">
                        <p class="buttons">
                            <span class="button btn-add" ng-click="onAddColumnEditConfig(templateItem, $event, $index)">添加字段</span>
                            <span class="button btn-save" ng-click="onSaveColumnEditConfig(templateItem, $event, $index)">保存</span>
                            <span class="button btn-cancel" ng-click="onCancelColumnEditConfig(templateItem, $event, $index)">取消</span>
                        </p>
                    </div>           
                </div>
                <div class="field-group row-group" style="padding-bottom: 0">
                    <div class="line"></div>
                    <div class="column-wrap table-layout">
                        <h4 class="field-group-label table-cell"> 字段组 </h4>
                        <div class="table-cell">
                            <a href="javascript:void(0)" class="btn-add-field-group" ng-click="onAddTableConfig(templateItem, $event, $index)"></a>
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
                            <div class="field-checkbox" ng-class="{checked: templateItem.is_category_by_group}" style="display: block; margin-bottom: 0" ng-click="toggleCheckbox($event); isCategoryByGroup($event)">
                                <input id="12" type="checkbox" class="hidden" ng-model="templateItem.is_category_by_group" ng-click="$event.stopPropagation();">
                                <label for="12">消费按类目分类</label>
                            </div>
                            <div class="field-table-content" style="margin-top: 20px;" ng-if="!templateItem.is_category_by_group">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>类目</th>
                                            <th>日期</th>
                                            <th>商家</th>
                                            <th>人员</th>
                                            <th>备注</th>
                                            <th>金额</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>类目A</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>类目B</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>  
                            <div class="field-table-content" style="margin-top: 20px;" ng-if="templateItem.is_category_by_group">
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
                            <div class="field-table-content" style="margin-top: 20px;" ng-if="templateItem.is_category_by_group">
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
                            <div class="field-checkbox" ng-class="{checked: isTypeChecked($index, templateItem)}" ng-attr-style="{{!$last || 'margin-bottom: 0'}}" ng-repeat="templateTypeItem in templateTypeArray" ng-click="toggleCheckbox($event, $index); updateTemplateType($event, $index, $parent.$index)">
                                <input type="checkbox" class="hidden" ng-value="{{$index}}" ng-init="labelForId = getUID()" id="{{labelForId}}" ng-click="$event.stopPropagation();">
                                <label for="{{labelForId}}">{{templateTypeItem}}</label>
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
                        <div class="table-cell field-table-content-multi-row" ng-init="tableHeaderLabelId = getUID()">
                            <div class="field-checkbox checked" style="{{$last?'margin-bottom:0':''}}" ng-class="{disabled: tableHeaderOptionsItem.disabled}" ng-click="toggleCheckbox($event)" ng-repeat="tableHeaderOptionsItem in tableHeaderOptions">
                                <input type="checkbox" class="hidden" id="{{tableHeaderLabelId}}_{{$index}}" ng-click="$event.stopPropagation();">
                                <label for="{tableHeaderLabelId}}_{{$index}}">{{tableHeaderOptionsItem.text}}</label>
                            </div>
                        </div>             
                    </div>
                    <div class="column-wrap table-layout">
                        <h4 class="field-table-label table-cell"> 页脚显示 </h4>
                        <div class="table-cell field-table-content-multi-row" ng-init="tableFooterLabelId = getUID()">
                            <div class="field-checkbox checked" style="{{$last?'margin-bottom: 0':''}}" ng-click="toggleCheckbox($event)" ng-repeat="tableFooterOptionsItem in tableFooterOptions">
                                <input type="checkbox" class="hidden" id="{{tableFooterLabelId}}_{{$index}}" ng-click="$event.stopPropagation();">
                                <label for="{{tableFooterLabelId}}_{{$index}}">{{tableFooterOptionsItem.text}}</label>
                            </div>
                        </div>             
                    </div>
                    <div class="column-wrap table-layout pager-size" style="border-bottom: 1px solid #f2f6fa;" ng-if="true">
                        <h4 class="field-table-label table-cell"> 打印模版 </h4>
                        <div class="table-cell field-table-content-multi-row" ng-init="paperSizeLabelId = getUID()">
                            <div class="field-radio" ng-class="{checked: $first}" ng-click="onRadioGroupClick($event)" ng-repeat="paperSizeItem in paperAvailableSize">
                                <input type="radio" class="hidden" value="">
                                <label for="{{paperSizeLabelId}}_{{$index}}">{{paperSizeItem.text}}</label>
                            </div>
                        </div>             
                    </div>
                </div>
            </div>

            <div class="paper-footer">
                <a href="javascript:void(0)" class="btn-cancel" ng-click="onCancelTemplate(templateItem, $event, $index)"></a>
                <a href="javascript:void(0)" class="btn-preview" ng-click="onPreviewTemplate($event, $index)"></a>
                <a href="javascript:void(0)" class="btn-save" ng-click="onSaveTemplate($event, $index)"></a>
            </div>
        </div>
    </div>
</div>
<script src="/static/js/mod/template/list.js"></script>