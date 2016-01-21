(function() {
    var phonecatApp = angular.module('reimApp', []);
    var _fieldCountLimit_ = 6;
    var _templateTypes_ = null;
    var _defaultColumnEditConfig_ = {
        "explanation": "",
        "name": "起始地点",
        "required": "0",
        "type": "1",
        "id": "3"
    };
    var _defaultTableEditConfig_ = {
        "name": "新的表格",
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
    }
    return {
        initialize: function() {
            phonecatApp.controller('templateController', ["$http", "$scope",
                function($http, $scope) {
                    // init edit config
                    $scope.templateEditMap = {};
                    
                    function loadPageData() {
                        $.when(
                            Utils.api('/company/get_template_list'),
                            Utils.api('/company/get_template_types')
                        ).done(function (rsTemplate, rsTypes) {
                            $scope.$apply(function  () {
                                $scope.templateTypeArray = rsTypes;
                                $scope.templateArray = rsTemplate['data'];
                            });
                        })
                    };

                    loadPageData();

                    // compute here
                    $scope.isTypeChecked = function  (index, templateData) {
                        if(templateData['type'].indexOf(index+'')!=-1) {
                            return true
                        } else {
                            return false
                        }
                    };

                    // events here
                    
                    $scope.onAccordionTemplate = function(item, $index, e) {
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
                    $scope.onDeleteTemplate = function(item, $index) {
                        $http.post('/company/dodelete_report_template/' + item.id).success(function(rs) {
                            // $scope.templateArray = rs['data'];
                            if (rs['status'] <= 0) {
                                return show_notify(rs['msg']);
                            }
                            $scope.templateArray.splice($index, 1);
                        });
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
                        });
                    };
                    $scope.toggleTableVisible = function  (e) {
                        var $table = $(e.target).parents('.field-table').find('.field-table-content');
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

                    $scope.toggleCheckbox = function  (e) {
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

                    $scope.onRadioGroupClick = function  (e) {
                        var $target = $(e.currentTarget);
                        $target.addClass('checked').siblings().removeClass('checked');
                    };

                    $scope.onAddColumnEditConfig = function (data, e, index) {
                        if($scope.templateEditMap[data.id][index].children.length > _fieldCountLimit_ - 1) {
                            return alert('字段不能超过' + _fieldCountLimit_ + ' 个');
                        }
                        $scope.templateEditMap[data.id][index].children.push(angular.copy(_defaultColumnEditConfig_));
                    };
                    $scope.onAddTableConfig = function (data, e, index) {
                        
                        if($scope.templateEditMap[data.id] && $scope.templateEditMap[data.id].length >=1) {
                            return show_notify('请处理完已有字段组');
                        }
                        if(!$scope.templateEditMap[data.id]) {
                            return ($scope.templateEditMap[data.id] = [angular.copy(_defaultTableEditConfig_)]);
                        }
                        $scope.templateEditMap[data.id].push(angular.copy(_defaultTableEditConfig_));
                    };
                    $scope.onRemoveColumnEditConfig = function(data, e, columnIndex, tableIndex) {
                        var table = $scope.templateEditMap[data.id][tableIndex];
                        if(table.children.length <=1) {
                            return alert('至少拥有一个字断')
                        }
                        table.children.splice(columnIndex, 1);                        
                    };

                    $scope.onRemoveTable = function  (data, e, tableIndex, templateIndex) {
                        $scope.templateArray[templateIndex].config.splice(tableIndex, 1);
                    };



                    $scope.onSaveColumnEditConfig = function (templateData, e, tableEditIndex, templateIndex) {
                        // 1. do check //over
                        // 2. get old data
                        // 3. read edit data
                        // 4. reset view state

                        var templateEditTableArray = $scope.templateEditMap[templateData.id];
                        templateEditTableArray = angular.copy(templateEditTableArray);

                        var data = angular.copy(templateData);
                        data.config.push.apply(data.config, templateEditTableArray);

                        Utils.api('/company/doupdate_report_template', {
                            method: "post",
                            data: {
                                temp_info: data
                            }
                        }).done(function  (rs) {
                            if(rs['status'] <= 0) {
                                return show_notify(rs['msg']);
                            }
                            $scope.$apply(function  (e) {
                                $scope.templateArray[templateIndex].config.push(templateEditTableArray[tableEditIndex]);
                                $scope.templateEditMap[data.id].splice(tableEditIndex, 1);
                            });
                        });
                    };

                    $scope.onCancelColumnEditConfig = function(data, e, columnIndex, tableIndex) {
                        alert('功能还在开发中');
                    };

                }
            ]);
        }
    }
})().initialize();