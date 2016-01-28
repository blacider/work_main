(function() {
    var reimApp = angular.module('reimApp', []);
    var _fieldCountLimit_ = 6;
    var _templateNameLengthLimit_ = 10;
    var _templateTypes_ = null;
    var _ON_TEMPLATE_ADD_ANIMATION_ = 'animated flash';
    var _defaultColumnEditConfig_ = {
        "explanation": "",
        "name": "",
        "required": "0",
        "type": ""
    };
    var _defaultTableEditConfig_ = {
        "name": "",
        "type": "0",
        "printable": "1",
        "children": [angular.copy(_defaultColumnEditConfig_)],
    };
    var _defaultTemplateName_ = '未命名报销单';
    var _defaultTemplateConfig_ = {
        "name": _defaultTemplateName_,
        "type": ['0'],
        "config": [],
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
            reimApp.controller('templateController', ["$http", "$scope", "$element",
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
                                $scope.isLoaded = true
                                $scope.templateTypeArray = rsTypes;
                                $scope.templateArray = rsTemplate['data'];

                                // remember all data
                                $scope.templateArrayOriginal = new ArrayCache(angular.copy(rsTemplate['data']));

                                // load local config
                                $scope.tableHeaderOptions = _defaultTableHeaderOptions_;
                                $scope.tableFooterOptions = _defaultTableFooterOptions_;
                                $scope.tableHeaderOptions = _defaultTableHeaderOptions_;
                                $scope.paperAvailableSize = _paperAvailableSize_;
                            });
                        })
                    };

                    /**
                     * define a array cache for template modify revert
                     */
                    var ArrayCache = (function() {
                        function ArrayCache(list) {
                            this.map = {};
                            for (var i = 0; i < list.length; i++) {
                                var item = list[i];
                                this.map[item.id] = item;
                            }
                        };
                        $.extend(ArrayCache.prototype, {
                            updateById: function(id, data) {
                                this.map[id] = data;
                            },
                            removeById: function(id) {
                                if (this.map[id]) {
                                    delete this.map[id];
                                    return true
                                } else {
                                    return false;
                                }
                            },
                            getItemById: function (id) {
                                return this.map[id];
                            }
                        });
                        return ArrayCache;
                    })();

                    var TemplateValidator = (function  () {
                        return {
                            howManyTemplateUnNamed: function(list) {
                                var count = 0;
                                for(var i=0;i<list.length;i++) {
                                    if(list[i].name.indexOf(_defaultTemplateName_)!=-1) {
                                        count++;
                                    }
                                }
                                return count;
                            },
                            isFieldTypeValid: function (columnObject) {
                                if(columnObject['type'] == 2) {
                                    if(!columnObject.property || !columnObject.property.options || columnObject.property.options.length<=0) {
                                        return {
                                            valid: false,
                                            code: 'NO_OPTIONS_ERROR',
                                            tip: '请选择选项类型',
                                            errorMsg: '无可用选项'
                                        }
                                    }
                                    var options = columnObject.property.options;
                                    for(var i=0;i<options.length;i++) {
                                        if($.trim(options[i])=='') {
                                            return {
                                                valid: false,
                                                code: 'OPTIONS_ITEM_EMPTY_ERROR',
                                                tip: '请在文本框输入可用的选项',
                                                errorMsg: '选项为空'
                                            }
                                        }
                                    }
                                }
                                var isValid = !!columnObject['type'];
                                if(!isValid) {
                                    return {
                                        valid: isValid,
                                        tip: '请选择字段类型',
                                        errorMsg: '无效的类型',
                                        code: 'INVALID_TYPE'
                                    }
                                }
                                return {
                                    valid: true,
                                    errorMsg: '',
                                    tip: '',
                                    code: 'OK'
                                }
                            },
                           isFieldTypeArrayValid: function  (columns) {
                                var invalidCount = 0;
                                var validatorArray = [];
                                for(var i = 0; i <columns.length; i++) {
                                    var validator = this.isFieldTypeValid(columns[i]);
                                    validatorArray.push(validator);
                                    validator.valid || invalidCount++;
                                }
                                return {
                                    invalidCount: invalidCount,
                                    validatorArray: validatorArray
                                };
                            }
                        }
                    })();

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
                        $element.find('.paper-header input').autoGrowInput({minWidth: 30, maxWidth: 600, comfortZone: 0});
                    };

                    loadPageData().done(function  (rs) {
                        makeTableSortable();
                        makeTitleAutoWidth();
                    });

                    // compute here
                    $scope.isTypeChecked = function  ($index, templateData) {
                        if(templateData['type'].indexOf($index+'')!=-1) {
                            console.log($index, templateData['type'].indexOf($index+''))
                            return true
                        } else {
                            return false
                        }
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
                        var $targetEle = $(e.currentTarget);
                        var $templateItem = $targetEle.parents('.paper');
                        $templateItem.removeClass(_ON_TEMPLATE_ADD_ANIMATION_)
                        if ($templateItem.hasClass('show')) {
                            $templateItem.removeClass('show');
                            
                        } else {
                            $templateItem.addClass('show').find('.paper-header').removeClass('fixed');
                            var offset = $element.find('.paper').eq(index).offset();
                            $('html, body').animate({
                                scrollTop: offset.top - 15
                            });
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
                        debugger
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

                    $scope.onAddTemplate = function(e) {

                        var templateData = angular.copy(_defaultTemplateConfig_);

                        var unnamedTemplateCount = TemplateValidator.howManyTemplateUnNamed($scope.templateArray);
                        if(unnamedTemplateCount>0) {
                            templateData.name = _defaultTemplateName_ + unnamedTemplateCount
                        }
                         
                        Utils.api('/company/docreate_report_template', {
                            method: 'post',
                            data: {
                                template_name: templateData['name'],
                                type: templateData['type']
                            }
                        }).done(function  (rs) {
                            // update arraycache
                            $scope.templateArrayOriginal.updateById(templateData.id, templateData);

                            if (rs['status'] <= 0) {
                                // $scope.templateArray.pop();
                                return show_notify(rs['msg']);
                            }

                            $scope.$apply(function () {
                                $scope.templateArray.push(templateData);
                                show_notify('添加成功！');

                                // angular do dom insert async
                                setTimeout(function () {
                                    $element.find('.paper:last').find('.paper-header input').autoGrowInput({minWidth: 30, maxWidth: 600, comfortZone: 0});
                                }, 1000);
                            });

                            var $paper = $element.find('.paper').eq($scope.templateArray.length -1);
                            $paper.find('.btn-accordion').trigger('click');
                            setTimeout(function  () {
                                $("body").animate({ scrollTop:  $paper.offset()['top']}, 300, function  () {});
                            }, 1000);
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

                    $scope.onRemoveTemplate = function(item, $index, e) {
                        if($scope.templateArray.length<=1) {
                            return show_notify('至少保留一份报销单模版!');
                        }
                        dialog({
                            title: '温馨提示',
                            content: '确认要删除当前报销单模版?',
                            width: 240,
                            skin: 'text-align',
                            align: 'bottom right',
                            ok: function  () {
                                var _self = this;
                                this.content('正在删除......');
                                $http.post('/company/dodelete_report_template/' + item.id).success(function(rs) {
                                    // $scope.templateArray = rs['data'];
                                    if (rs['status'] <= 0) {
                                        _self.content('确认要删除当前报销单模版?');
                                        return show_notify(rs['msg']);
                                    }

                                    _self.close();

                                    $element.find('.paper').eq($index).addClass('animated fadeOut');

                                    setTimeout(function  () {
                                        $scope.$apply(function  () {
                                            $scope.templateArray.splice($index, 1);
                                        })
                                    }, 1000);
                                });
                                return false;
                            },
                            cancel: function  () {
                                this.close();
                            },
                            okValue: '删除',
                            cancelValue: '取消'
                        }).showModal(e.currentTarget);
                        
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

                        if(data.type.length == 0) {
                            return show_notify('请选择报销模版适用范围');
                        }

                        if(TemplateValidator.howManyTemplateUnNamed($scope.templateArray)>0) {
                            show_notify('检测到'+_defaultTemplateName_);
                        }

                        var loading = dialog({
                            content: '正在上传数据......'
                        }).showModal();

                        Utils.api('/company/doupdate_report_template', {
                            method: "post",
                            data: {
                                temp_info: data
                            }
                        }).done(function  (rs) {
                            loading.close();
                            if(rs['status'] <= 0) {
                                return show_notify(rs['msg']);
                            }
                            // update array cache
                            $scope.templateArrayOriginal.updateById(data.id, data);
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

                        var validator = TemplateValidator.isFieldTypeArrayValid(templateEditTable.children);

                        if(validator['invalidCount']>0) {
                            return show_notify(validator.validatorArray[0].tip);
                        }

                        if(data.type.length == 0) {
                            return show_notify('请选择报销模版适用范围');
                        }

                        var loading = dialog({
                            content: '正在上传数据......'
                        }).showModal();

                        Utils.api('/company/doupdate_report_template', {
                            method: "post",
                            data: {
                                temp_info: data
                            }
                        }).done(function  (rs) {
                            loading.close();
                            if(rs['status'] <= 0) {
                                return show_notify(rs['msg']);
                            }
                            show_notify('保存成功！');
                            $scope.$apply(function (e) {
                                $scope.templateArray[templateIndex]
                                $scope.templateArray[templateIndex].config.push(templateEditTable);
                                $scope.templateEditTableMap[data.id] = null;
                            });
                        });
                    };

                    $scope.onCancelTemplate = function  (data, e, $index) {

                        $scope.templateEditTableMap[data.id] = null;
                        var originalTemplateData = $scope.templateArrayOriginal.getItemById(data.id);
                        originalTemplateData.isShow = true;
                        originalTemplateData.isHeaderFixed = true;
                        $scope.templateArray[$index] = angular.copy(originalTemplateData);
                    };

                    $scope.onCancelColumnsEditConfig = function(templateData, e, templateIndex) {
                        var tableData = $scope.templateEditTableMap[templateData.id];
                        dialog({
                            title: '温馨提示',
                            content: '取消操作，编辑后的内容将不会被保存哦',
                            ok: function  () {
                                var _edit_swap_ = tableData['_EDIT_SWAP_'];
                                // 检测是否要会滚
                                if(_edit_swap_ && _edit_swap_['type'] == 'update') {

                                    $scope.templateArray[_edit_swap_.templateIndex];

                                    $scope.$apply(function  () {
                                        $scope.templateArray[templateIndex].config.splice(_edit_swap_.tableIndex, 0, _edit_swap_.originTableData);
                                    })

                                }
                                //丢弃编辑内容
                                $scope.$apply(function  () {
                                    $scope.templateEditTableMap[templateData.id] = null;
                                })

                                return true;
                            },
                            okValue: '确认取消'
                        }).showModal();
                    };

                    $scope.onFocusOut = function  (templateData, $index, e) {
                        var $input = $(e.target);
                        var name = $input.val();
                        name = $.trim(name) || '';
                        $input.val(name);
                        if(name.length>_templateNameLengthLimit_) {
                            $input.val(name.substr(0, _templateNameLengthLimit_));
                            $input.trigger('autogrow')
                            return false;
                        }
                        $input.attr('disabled', true);
                        $scope.templateArray[$index].name = name;

                        return true;
                    };

                    $scope.onEditTemplateTitle = function  (e) {
                        var $target = $(e.currentTarget);
                        $target.find('input').attr('disabled', false).focus();
                    };

                    $scope.getUID = function  () {
                        return Utils.uid();
                    };

                    $(window).on('scroll', function  () {
                        // 1. get the target element
                        // 2. set the target element as scroll, and othernot scroll
                        var scrollTop = $(window).scrollTop();

                        $element.find('.paper.show').each(function  (index, item) {
                            var $item = $(item);
                            var $itemHeader = $item.find('.paper-header');
                            var offset = $item.offset(); 

                            console.log(offset.top, scrollTop, index);

                            if(offset.top <= scrollTop && offset.top + $item.height() >= scrollTop) {
                                $itemHeader.addClass('fixed');
                                $itemHeader.next();
                            } else {
                                $itemHeader.removeClass('fixed');
                                $itemHeader.next().css('margin-top', 0);
                            }
                        });
                        
                    });

                }
            ]);
        }
    }
})().initialize();

//创建模版默认类型