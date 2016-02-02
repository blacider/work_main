(function() {
    
    var _fieldCountLimit_ = 6;
    var _radioOptionsCountLimit_ = 6;
    var _templateNameLengthLimit_ = 10;
    var _templateTotalLimit_ = 10;
    var _templateTypes_ = null;
    var _ON_TEMPLATE_ADD_ANIMATION_ = 'animated flash';
    var _defaultColumnEditConfig_ = {
        "explanation": "",
        "name": "",
        "required": "0",
        "type": "1"
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
            value: '',
            checked: true
        },
        {
            disabled: true,
            text: '提交时间',
            value: '',
            checked: true
        },
        {
            disabled: true,
            text: '提交者姓名',
            value: '',
            checked: true
        },
        {
            disabled: true,
            text: '金额',
            value: '',
            checked: true
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
            angular.module('reimApp', ['ng-sortable']).controller('templateListController', ["$http", "$scope", "$element",
                function($http, $scope, $element) {
                    
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

                                if(!columnObject['name']) {
                                    return {
                                        valid: false,
                                        tip: '请填写字段名称',
                                        errorMsg: '空的字段名',
                                        code: 'EMPTY_FIELD_NAME'
                                    }   
                                }

                                return {
                                    valid: true,
                                    errorMsg: '',
                                    tip: '',
                                    code: 'OK'
                                }
                            },
                            getInvalidFieldTypeArray: function  (columns) {
                                var invalidCount = 0;
                                var validatorArray = [];
                                for(var i = 0; i <columns.length; i++) {
                                    var validator = this.isFieldTypeValid(columns[i]);
                                    if(!validator.valid) {
                                        validatorArray.push(validator);
                                        invalidCount++;
                                    }
                                }
                                return {
                                    invalidCount: invalidCount,
                                    validatorArray: validatorArray
                                };
                            },
                            tryGetEditingTemplateID: function  () {
                                for (var id in $scope.templateUpdateTableMap) {
                                    if($scope.templateUpdateTableMap[id]) {
                                        return id;
                                    }
                                }
                                return null;
                            },
                            isTemplataChanged: function  (currentTemplateData) {
                                var data = angular.copy(currentTemplateData);
                                var originalData = angular.copy($scope.templateArrayOriginal.getItemById(templateData.id));
                                return angular.equals(templateData, originalData);
                            },
                            getTemplateByID: function  (id) {
                                for (var i = $scope.templateArray.length - 1; i >= 0; i--) {
                                    if ($scope.templateArray[i]['id'] === id) {
                                        return $scope.templateArray[i];
                                    }
                                };
                                return null;
                            }
                        }
                    })();

                    // ani action leads to save the template
                    // accordion temlate \add new template \save the template
                    // 1. first to make the the table-editing 'ensured'
                    // 2. then try to ask the user is to save or not
                    // all editing work is in the open template, right? so get the open template and to find the editing table;
                    // 
                    function doClearOpenTemplateData (templateData, $index) {
                        var def = $.Deferred();
                        var $openTemplate = $element.find('.paper.show');
                        if($openTemplate.length==1) {
                            // get the open template date
                            $index = $openTemplate.data('index');
                            templateData = $scope.templateArray[$index];

                            var originalData = $scope.templateArrayOriginal.getItemById(templateData.id);
                            originalData = angular.copy(originalData);

                            data = angular.copy(templateData);

                            if(!angular.equals(data, originalData)) {
                                var d = new CloudDialog({
                                    content: '是否要保存编辑的内容？',
                                    width: 240,
                                    fixed: true,
                                    ok: function  () {
                                        var _self = this;
                                        
                                        Utils.api('/company/doupdate_report_template', {
                                            method: "post",
                                            data: {
                                                temp_info: data
                                            }
                                        }).done(function  (rs) {

                                            if(rs['status'] <= 0) {
                                                def.resolve();
                                                return show_notify(rs['msg']);
                                            }

                                            setTimeout(function  () {
                                                _self.close();
                                                def.resolve();
                                                show_notify('保存成功！');
                                            }, 800);
                                            
                                            // update array cache
                                            $scope.templateArrayOriginal.updateById(data.id, data);
                                            $(window).scrollTop($(window).scrollTop());

                                        });
                                         
                                        return false;
                                    },
                                    cancel: function  () {
                                        this.close();
                                        templateData = angular.copy(templateData);

                                        var originalTemplateData = $scope.templateArrayOriginal.getItemById(templateData.id);

                                        if(angular.equals(templateData, originalTemplateData)) {
                                            return def.resolve();
                                        }

                                        $scope.$apply(function  () {
                                            $scope.templateArray[$index] = angular.copy(originalTemplateData);
                                        });

                                        def.resolve();
                                    },
                                    okValue: '保存',
                                    cancelValue: '不保存'
                                });
                                d.showModal();
                            } else {
                                def.resolve();
                            }
                        } else {
                            def.resolve();
                        }
                        return def.promise();
                    };

                    function makeTitleAutoWidth (el) {
                        var $eles = $element.find('.paper-header input');
                        if(el) {
                            $eles = $(el);
                        }
                        setTimeout(function  () {
                            $eles.autoGrowInput({minWidth: 30, maxWidth: 200, comfortZone: 0});
                        }, 0);
                    };

                    loadPageData().done(function  (rs) {
                            // remember all template data as cache
                        $scope.templateArrayOriginal = new ArrayCache(angular.copy($scope.templateArray));

                    });

                    $scope.makeTableSortable = {
                        handle: ".btn-drag",
                        draggable: '.field-table',
                        animation: 150,
                        ghostClass: 'sortable-ghost',
                        chosenClass: "sortable-chosen",
                        scroll: true,
                        onUpdate: function (e) {
                            // 交换数组两个元素的位置
                        }
                    };

                    // compute here
                    $scope.initTemplateItem = function  (templateData, $index) {
                        // data variable
                        // default use type
                        if(templateData['type'].length==0) {
                            templateData['type'].push('0');
                        }

                        templateData.is_category_by_group = true;

                    };

                    $scope.onFieldTypeChange = function  (type, columnData) {
                        if(type==2) {
                            if(!columnData['property']) {
                                columnData['property'] = {};
                            }
                            if(!columnData['property']['options']) {
                                columnData['property']['options'] = ['', ''];
                            }
                        }
                    };

                    $scope.setOptionsForRadioGroup = function  (e, tableData, inputIndex, columnIndex) {
                        if($(e.currentTarget).hasClass('btn-delete-input')) {
                            tableData.children[columnIndex]['property'].options.splice(inputIndex, 1);
                        } else {
                            if(tableData.children.length >= _radioOptionsCountLimit_) {
                                return show_notify('单选选项不能超过'+_radioOptionsCountLimit_);
                            }
                            tableData.children[columnIndex]['property'].options.push('');
                        }
                    };

                    // events here
                    $scope.onAccordionTemplate = function(templateData, $index, e) {
                        makeTitleAutoWidth($element.find('.paper').eq($index).find('.paper-header input'));
                        // 由于目前只能展开一个模版，所以只需要检测展开的那个模版就OK，处理完展开的模版的对话框，做好折叠工作
                        // 在处理完成上述操作以后，检测是不是其它模版被点击折叠，是的话还要toggle template
                        var $openTemplate = $element.find('.paper.show');
                        doClearOpenTemplateData(templateData, $index).done(function  () {
                            var $targe = $(e.currentTarget);
                            var $templateItem = $targe.parents('.paper');
                            $templateItem.removeClass(_ON_TEMPLATE_ADD_ANIMATION_);
                            if ($templateItem.hasClass('show')) {
                                $templateItem.removeClass('show').find('.paper-header').removeClass('fixed');
                            } else {
                                var $templateSiblings = $templateItem.siblings().removeClass('show');
                                $templateSiblings.find('.paper-header').removeClass('fixed');

                                $templateItem.addClass('show').siblings().removeClass('show');

                                var offset = $element.find('.paper').eq($index).offset();

                                $('html, body').animate({
                                    scrollTop: offset.top - 15
                                });
                            }
                        });
                    };

                    $scope.onPreviewTemplate = function  (argument) {
                        alert('预览模版－功能开发中')
                        // body...
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

                    $scope.onAddTemplate = function(e) {

                        var templateData = angular.copy(_defaultTemplateConfig_);

                        // 检测长度
                        if($scope.templateArray.length >=_templateTotalLimit_) {
                            return show_notify('可用模版不能超过' +_templateTotalLimit_+'个');
                        }

                        doClearOpenTemplateData().done(function  () {
                            Utils.api('/company/docreate_report_template', {
                                method: 'post',
                                data: {
                                    template_name: templateData['name'],
                                    type: templateData['type']
                                }
                            }).done(function  (rs) {
                                // update arraycache
                                $scope.templateArrayOriginal.updateById(templateData.id, templateData);

                                if (!rs['id'] || rs['id'] == -1) {
                                    // $scope.templateArray.pop();
                                    return show_notify(rs['msg'] || '模版创建失败');
                                }

                                $scope.$apply(function () {
                                    $scope.templateArray.push(templateData);
                                    // angular do dom insert async
                                });

                                var $paper = $element.find('<div class="paper"></div>').eq($scope.templateArray.length -1);
                                $paper.find('.btn-accordion').trigger('click');
                            });
                        })
                    };
                    
                    $scope.onAddTableConfig = function (templateData, e, templateIndex) {
                        
                        var tableData = angular.copy(_defaultTableEditConfig_);
                        tableData['MODE'] = 'STATE_EDITING';
                        $scope.templateArray[templateIndex].config.push(tableData);
                    };
                    
                    $scope.onAddColumnEditConfig = function (tableData, e, index) {

                        // 1. length limit check
                        if(tableData.children.length > _fieldCountLimit_ - 1) {
                            return show_notify('字段不能超过' + _fieldCountLimit_ + ' 个');
                        }

                        tableData.children.push(angular.copy(_defaultColumnEditConfig_));

                    };

                    $scope.onRemoveTemplate = function(item, $index, e) {
                        if($scope.templateArray.length<=1) {
                            return show_notify('至少保留一份报销单模版!');
                        }
                        var d = new CloudDialog({
                            content: '确认要删除当前报销单模版?',
                            width: 240,
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
                        });
                        d.showModal(e.currentTarget);
                        
                    };

                    $scope.onRemoveTable = function  (e, tableIndex, templateIndex) {
                        var $table = $(e.currentTarget).parents('.field-table');
                        $table.addClass('animated fadeOut');
                        setTimeout(function  () {
                            $table.remove();
                            $scope.templateArray[templateIndex].config.splice(tableIndex, 1);
                        }, 1000);
                    };

                    $scope.onRemoveColumnEditConfig = function(e, tableData, columnIndex) {
                        if(tableData.children.length <=1) {
                            return show_notify('至少有一个字段');
                        }
                        var $fields = $(e.currentTarget).parents('.fields');
                        $fields.addClass('animated fadeOut');
                        setTimeout(function  () {
                            $fields.remove();
                            tableData.children.splice(columnIndex, 1);                        
                        }, 1000);
                    };

                    // template event
                    $scope.onSaveTemplate = function  (e, index) {
                        var templateData = $scope.templateArray[index];
                        var data = angular.copy(templateData);

                        if(data.type.length == 0) {
                            return show_notify('请选择报销模版适用范围');
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
                            // update array cache
                            show_notify('保存成功！');
                            $scope.templateArrayOriginal.updateById(data.id, data);
                        });

                    };

                    $scope.onSaveColumnsEditConfig = function (templateData, e, tableIndex, templateIndex) {
                        var tableData = templateData.config[tableIndex];
                        var validator = TemplateValidator.getInvalidFieldTypeArray(tableData.children);

                        if(validator['invalidCount']>0) {
                            return show_notify(validator.validatorArray[0].tip);
                        }

                        delete tableData['MODE'];

                    };

                    $scope.onCancelTemplate = function  (templateData, e, $index) {
                        var originalTemplateData = $scope.templateArrayOriginal.getItemById(templateData.id);
                        var d = new CloudDialog({
                            content: '确定要取消编辑的内容？',
                            fixed: true,
                            ok: function  () {
                                $scope.$apply(function  () {
                                    $scope.templateArray[$index] = angular.copy(originalTemplateData);
                                });
                                var _self = this;
                                setTimeout(function  () {
                                    _self.close(true);
                                }, 1000);
                            },
                            cancel: null
                        });
                        d.showModal();
                    };

                    $scope.onCancelColumnsEditConfig = function(tableData, e, templateIndex) {
                        delete tableData['MODE'];
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

                    $scope.onEditTable = function (e, tableIndex, templateIndex) {

                        var templateData = $scope.templateArray[templateIndex];
                        var tableData = angular.copy(templateData.config[tableIndex]);
                        var originTableData = angular.copy(tableData);

                        // 丢弃编辑项目，时候，回滚的位置的信息，并记录会滚信息
                        $scope.templateArray[templateIndex].config[tableIndex]['MODE'] = 'STATE_EDITING'

                    };

                    $scope.onEditTemplateTitle = function  (templateData, e) {
                        var $target = $(e.currentTarget);
                        if(!$(e.currentTarget).parents('.paper').hasClass('show')) {
                            return;
                        }
                        $target.find('input').attr('disabled', false).focus();
                    };

                    $scope.getUID = function  () {
                        return Utils.uid();
                    };

                    $(window).on('scroll', function  () {
                        // 1. get the target element
                        // 2. set the target element as scroll, and othernot scroll
                        $element.find('.paper:not(.show)').removeClass('fixed');
                        var scrollTop = $(window).scrollTop();
                        $element.find('.paper.show').each(function  (index, item) {
                            var $item = $(item);
                            var $itemHeader = $item.find('.paper-header');
                            var offset = $item.offset(); 

                            // console.log(offset.top, scrollTop, index);

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