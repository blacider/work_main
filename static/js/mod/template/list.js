(function() {
    var phonecatApp = angular.module('reimApp', []);
    var _fieldCountLimit_ = 6;
    var _templateNameLengthLimit_ = 10;
    var _templateTypes_ = null;
    var _defaultColumnEditConfig_ = {
        "explanation": "",
        "name": "",
        "required": "0",
        "type": "",
        "id": "3"
    };
    var _defaultTableEditConfig_ = {
        "name": "未命名报销单",
        "type": "0",
        "printable": "1",
        "children": [angular.copy(_defaultColumnEditConfig_)],
    };
    var _defaultTemplateConfig_ = {
        "id": "39",
        "name": "差旅报销单" + Date.now(),
        "type": ["2"],
        "config": [{
            "name": "差旅详情",
            "type": "0",
            "printable": "1",
            "children": [{
                "explanation": "",
                "name": "起始地点",
                "required": "0",
                "type": "1",
                "id": "3"
            }, {
                "explanation": "",
                "name": "起始日期",
                "required": "0",
                "type": "1",
                "id": "6"
            }, {
                "explanation": "",
                "name": "事由",
                "required": "0",
                "type": "1",
                "id": "11"
            }],
            "id": "21"
        }, {
            "name": "1",
            "type": "0",
            "printable": "0",
            "children": [{
                "explanation": "",
                "name": "2",
                "required": "0",
                "type": "4",
                "property": {
                    "bank_account_type": "1"
                },
                "id": "16"
            }],
            "id": "22"
        }],
        "disabled": "0"
    };

    var _defaultTableHeaderOptions_ = [
        {
            disabled: true,
            text: '报销单名称',
            value: ''
        },
        {
            disabled: true,
            text: '提交时间',
            value: ''
        },
        {
            disabled: true,
            text: '提交者姓名',
            value: ''
        },
        {
            disabled: true,
            text: '金额',
            value: ''
        },
        {
            disabled: false,
            text: '提交者职位',
            value: ''
        },
        {
            disabled: false,
            text: '提交者部门',
            value: ''
        },
        {
            disabled: false,
            text: '提交者上级部门',
            value: ''
        },
        {
            disabled: false,
            text: '提交者ID',
            value: ''
        },
        {
            disabled: false,
            text: '提交者电话',
            value: ''
        },
        {
            disabled: false,
            text: '提交者邮箱',
            value: ''
        }
    ];

    var _defaultTableFooterOptions_ = [
        {
            text: '公司名称',
            value: ''
        },
        {
            text: '部门名称',
            value: ''
        }
    ];

    var _paperAvailableSize_ = [
        {
            text: 'A4模版',
            key: 'a4'
        },
        {
            text: 'A5模版',
            key: 'a5'
        },
        {
            text: 'B5模版',
            key: 'b5'
        }
    ]

    return {
        initialize: function() {
            phonecatApp.controller('templateController', ["$http", "$scope", "$element",
                function($http, $scope, $element) {
                    // init edit config
                    // templateEditTableMap = {
                    //      '331313': { template id
                    //             type: '1'
                    //             children: [col_0,...col_n]
                    //      }
                    // }
                    $scope.templateEditTableMap = {};
                    
                    function loadPageData() {
                        return $.when(
                            Utils.api('/company/get_template_list'),
                            Utils.api('/company/get_template_types')
                        ).done(function (rsTemplate, rsTypes) {
                            $scope.$apply(function  () {
                                // load remote config
                                $scope.templateTypeArray = rsTypes;
                                $scope.templateArray = rsTemplate['data'];

                                // load local config
                                $scope.tableHeaderOptions = _defaultTableHeaderOptions_;
                                $scope.tableFooterOptions = _defaultTableFooterOptions_;
                                $scope.tableHeaderOptions = _defaultTableHeaderOptions_;
                                $scope.paperAvailableSize = _paperAvailableSize_;
                            });
                        })
                    };
                    // 拖动后编辑，是大坑
                    function makeTableSortable() {
                        if($element.find('.table-container .field-table').length<=0) {
                            return;
                        }
                        Sortable.create($element.find('.table-container')[0], {
                            handle: ".btn-drag",
                            draggable: '.field-table',
                            animation: '150',
                            ghostClass: 'sortable-ghost',
                            chosenClass: "sortable-chosen",
                            scroll: true,
                            onStart: function  (e) {
                                // body...
                            },
                            onEnd: function (e) {
                                // 交换数组两个元素的位置
                                if(e.newIndex === undefined) {
                                    return
                                }
                                var templateIndex = $element.find('.paper').index($(e.target).parents('.paper'));

                                var tableTransfer = $scope.templateArray[templateIndex].config.splice(e.oldIndex, 1);
                                tableTransfer = tableTransfer[0];
                                $scope.templateArray[templateIndex].config.splice(e.newIndex, 0, tableTransfer);
                                
                            }
                        });
                    };

                    function makeTitleAutoWidth () {
                        $element.find('.paper-header input').autoGrowInput({minWidth: 30, maxWidth: 600});
                    };

                    loadPageData().done(function  (rs) {
                        makeTableSortable();
                        makeTitleAutoWidth()
                    });

                    // compute here
                    $scope.isTypeChecked = function  (index, templateData) {
                        if(templateData['type'].indexOf(index+'')!=-1) {
                            return true
                        } else {
                            return false
                        }
                    };

                    $scope.setFocusEnd = function(e) {
                        var str = e.target.value;
                        if(str.length >=_templateNameLengthLimit_) {
                            str = str.substr(0, _templateNameLengthLimit_)
                        }

                        e.target.value = str;
                        // $(e.target).trigger('click')
                    };

                    $scope.onFieldTypeChange = function  (type, templateData, columnIndex) {
                        if(type==2) {
                            $scope.templateEditTableMap[templateData.id].children[columnIndex]['property'] || ($scope.templateEditTableMap[templateData.id].children[columnIndex]['property'] = {options: ["", ""]});
                        }
                    };

                    $scope.setOptionsForRadioGroup = function  (templateData, columnIndex, inputIndex, e) {
                        if($(e.currentTarget).hasClass('btn-delete-input')) {
                            $scope.templateEditTableMap[templateData.id].children[columnIndex]['property'].options.splice(inputIndex, 1);
                        } else {
                            $scope.templateEditTableMap[templateData.id].children[columnIndex]['property'].options.push('');
                        }
                    };

                    // events here
                    $scope.onAccordionTemplate = function(item, index, e) {
                        var $targetEle = angular.element(e.target);
                        var $templateItem = $targetEle.parent().parent().parent();
                        if ($templateItem.hasClass('shrink')) {
                            $templateItem.removeClass('shrink')
                        } else {
                            $templateItem.addClass('shrink')
                        }
                    };
                    $scope.onPreviewTemplate = function  (argument) {
                        alert('预览模版－功能开发中')
                        // body...
                    };
                    
                    
                    $scope.toggleTableVisible = function  (e) {
                        var $table = $(e.target).parents('.field-table').find('.field-table-content, .category-table');
                        if($table.hasClass('none')) {
                            $table.removeClass('none');
                        } else {
                            $table.addClass('none')
                        }
                    };
                    $scope.togglePrintSettings = function  (e) {
                        var $target = $(e.target);
                        var $groupContainer = $(e.target).parents('.field-table').find('.group-container');
                        if($groupContainer.hasClass('none')) {
                            $target.addClass('btn-up')
                            $groupContainer.removeClass('none');
                        } else {
                            $groupContainer.addClass('none')
                            $target.removeClass('btn-up')
                        }
                    };

                    $scope.toggleCheckbox = function  (e, index) {
                        var $target = $(e.target).parent();
                        if($target.hasClass('disabled')) {
                            return
                        }
                        if($target.hasClass('checked')) {
                            $target.removeClass('checked');
                        } else {
                            $target.addClass('checked');
                        }
                    };

                    $scope.updateTemplateType = function(e, index, templateIndex) {
                        if($(e.currentTarget).hasClass('checked')) {

                            $scope.templateArray[templateIndex].type.push(index + '');

                        } else {
                            var idx = $scope.templateArray[templateIndex].type.indexOf(index + '');
                            if(idx!=-1) {
                                $scope.templateArray[templateIndex].type.splice(idx, 1);
                            }
                        }
                    };

                    $scope.onRadioGroupClick = function  (e) {
                        var $target = $(e.currentTarget);
                        $target.addClass('checked').siblings().removeClass('checked');
                    };

                    $scope.onEditTable = function  (e, tableIndex, templateIndex) {
                        var templateData = $scope.templateArray[templateIndex];
                        var tableData = angular.copy(templateData.config[tableIndex]);
                        var originTableData = angular.copy(tableData);
                        // 检测是否已经有编辑项目了
                        if($scope.templateEditTableMap[templateData.id]) {
                            return show_notify('请保存或取消正在编辑的字段组');
                        }

                        // 丢弃编辑项目，时候，回滚的位置的信息，并记录会滚信息
                        
                        tableData['_EDIT_SWAP_'] = {
                            type: 'update',
                            templateIndex: templateIndex,
                            tableIndex, tableIndex,
                            originTableData: originTableData
                        };

                        $scope.templateArray[templateIndex].config.splice(tableIndex, 1);
                        $scope.templateEditTableMap[templateData.id] = angular.copy(tableData);
                    };

                    $scope.onAddTemplate = function() {
                        var templateData = angular.copy(_defaultTemplateConfig_);
                        $scope.templateArray.push(templateData);

                        Utils.api('/company/docreate_report_template', {
                            method: 'post',
                            data: {
                                template_name: templateData['name']
                            }
                        }).done(function  (rs) {
                            if (rs['status'] <= 0) {
                                $scope.templateArray.pop();
                                return show_notify(rs['msg']);
                            }
                            makeTitleAutoWidth()
                        });

                    };
                    
                    $scope.onAddTableConfig = function (data, e, index) {
                        if($scope.templateEditTableMap[data.id]) {
                            return show_notify('请处理完并保存编辑中的字段组');
                        }
                        if(!$scope.templateEditTableMap[data.id]) {
                            $scope.templateEditTableMap[data.id] = angular.copy(_defaultTableEditConfig_);
                        }
                    };
                    
                    $scope.onAddColumnEditConfig = function (data, e, index) {
                        // 1. length limit check
                        if($scope.templateEditTableMap[data.id].children.length > _fieldCountLimit_ - 1) {
                            return alert('字段不能超过' + _fieldCountLimit_ + ' 个');
                        }
                        // 2. input check
                        if(true) {
                            show_notify('请输入字段要求')
                        }

                        $scope.templateEditTableMap[data.id].children.push(angular.copy(_defaultColumnEditConfig_));
                    };

                    $scope.onRemoveTemplate = function(item, $index) {
                        $http.post('/company/dodelete_report_template/' + item.id).success(function(rs) {
                            // $scope.templateArray = rs['data'];
                            if (rs['status'] <= 0) {
                                return show_notify(rs['msg']);
                            }
                            $scope.templateArray.splice($index, 1);
                        });
                    };

                    $scope.onRemoveTable = function  (e, tableIndex, templateIndex) {
                        $scope.templateArray[templateIndex].config.splice(tableIndex, 1);
                        var data = angular.copy($scope.templateArray[templateIndex]);
                        Utils.api('/company/doupdate_report_template', {
                            method: "post",
                            data: {
                                temp_info: data
                            }
                        }).done(function  (rs) {
                            if(rs['status'] <= 0) {
                                return show_notify(rs['msg']);
                            }
                            show_notify('字段组已删除')
                            
                        });
                    };

                    $scope.onRemoveColumnEditConfig = function(data, e, columnIndex, templateIndex) {
                        var table = $scope.templateEditTableMap[data.id];
                        if(table.children.length <=1) {
                            return alert('至少拥有一个字断')
                        }
                        table.children.splice(columnIndex, 1);                        
                    };

                    // template event
                    $scope.onSaveTemplate = function  (e, index) {
                        var templateData = $scope.templateArray[index];
                        var data = angular.copy(templateData);
                        Utils.api('/company/doupdate_report_template', {
                            method: "post",
                            data: {
                                temp_info: data
                            }
                        }).done(function  (rs) {
                            if(rs['status'] <= 0) {
                                return show_notify(rs['msg']);
                            }
                            show_notify('保存成功！');
                        });

                    };

                    $scope.onSaveColumnsEditConfig = function (templateData, e, templateIndex) {
                        // 1. do check //over
                        // 2. get old data
                        // 3. read edit data
                        // 4. reset view state

                        var templateEditTable = $scope.templateEditTableMap[templateData.id];
                        templateEditTable = angular.copy(templateEditTable);

                        var data = angular.copy(templateData);

                        data.config.push(templateEditTable);

                        if(data.type.length == 0) {
                            data.type = ['0'];
                        }



                        Utils.api('/company/doupdate_report_template', {
                            method: "post",
                            data: {
                                temp_info: data
                            }
                        }).done(function  (rs) {
                            if(rs['status'] <= 0) {
                                return show_notify(rs['msg']);
                            }
                            $scope.$apply(function (e) {
                                $scope.templateArray[templateIndex]
                                $scope.templateArray[templateIndex].config.push(templateEditTable);
                                $scope.templateEditTableMap[data.id] = null;
                            });
                        });
                    };

                    $scope.onCancelTemplate = function  (data, e, index) {
                        $scope.templateEditTableMap[data.id] = null;
                    };

                    function putBackUpdatingTable($scope, tableData) {

                    };

                    $scope.onCancelColumnsEditConfig = function(templateData, e, templateIndex) {

                        var tableData = $scope.templateEditTableMap[templateData.id];

                        if(confirm('你真的要取消?')) {
                            // 回滚
                            var _edit_swap_ = tableData['_EDIT_SWAP_'];
                            if(_edit_swap_ && _edit_swap_['type'] == 'update') {
                                $scope.templateArray[_edit_swap_.templateIndex];

                                $scope.templateArray[templateIndex].config.splice(_edit_swap_.tableIndex, 0, _edit_swap_.originTableData);
                                $scope.templateEditTableMap[templateData.id] = null;
                            } else {//丢弃
                                $scope.templateEditTableMap[templateData.id] = null;
                            }
                            
                        }
                    };

                    $scope.getUID = function  () {
                        return Utils.uid();
                    };

                }
            ]);
        }
    }
})().initialize();